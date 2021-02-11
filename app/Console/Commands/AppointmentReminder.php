<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\RadetAppt;
use SmsTo;
use Carbon\Carbon;
use App\Manager;
use App\Http\Controllers\AppointmentController as Appointments;

class AppointmentReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:case_managers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send alerts (Emails and SMS) to case managers, reminding them of due appointments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appt3Days = RadetAppt::whereDate('appt_date', Carbon::now()->addDays(3))->limit(3)->get();
        $appt2Days = RadetAppt::whereDate('appt_date', Carbon::now()->addDays(2))->limit(3)->get();
        $appt1Day = RadetAppt::whereDate('appt_date', Carbon::now()->addDays(1))->limit(3)->get();

        //3 days to
        if (!$appt3Days->isEmpty()) {
            $appts = $appt3Days->groupBy('case_manager');
            foreach ($appts as $key => $value) {
                $email = $this->getEmail($key);
                if (empty($email)) {
                    continue;
                }
                $this->sendMailReminder($value, 3, $email, $key);
            }
        }

        //Two days to
        if (!$appt2Days->isEmpty()) {
            $appts = $appt2Days->groupBy('case_manager');
            foreach ($appts as $key => $value) {
                $email = $this->getEmail($key);
                if (empty($email)) {
                    continue;
                }
                $this->sendMailReminder($value, 2, $email, $key);
            }
        }

        //1 day to
        if (!$appt1Day->isEmpty()) {
            $appts = $appt1Day->groupBy('case_manager');
            foreach ($appts as $key => $value) {
                $email = $this->getEmail($key);
                if (empty($email)) {
                    continue;
                }
                $this->sendMailReminder($value, 1, $email, $key);
            }
        }
    }

    private function sendMailReminder($appt_data, $days, $email, $case_manager)
    {
        $date = $appt_data[0]->created_at;
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.appt_reminder', ['data'=>$appt_data, 'days'=>$days, 'case_manager'=>$case_manager, 'date'=>$date], function($message) use ($email)
        {
            $message
                ->from('smtp@mailshunt.com','Q-MAMS - Fhi360')
                ->to('ekupnse16@gmail.com')
                ->to($email)
                ->cc('pimohi@ahnigeria.org', 'Philip Imohi')
                ->cc('IAbah@ahnigeria.org', 'Ikechukwuka Abah')
                ->cc('bigmikeeneji@gmail.com', 'Michael Eneji')
                ->cc('osanwo@fhi360.org')
                ->cc('spandey@fhi360.org')
                ->cc('cobiora-okafo@fhi360.org')
                ->cc('feyam@ng.fhi360.org', 'Frank Eyam')
                ->cc('cobi@ahnigeria.org', 'Cajetan Obi')
                ->subject('Pre-appointment Notice');
        });
        return true;
    }

    private function getEmail($case_manager)
    {
       $mg = Manager::where('names', $case_manager)->first();
       if ($mg) {
           return $mg->email;
       }
    }

    private function sendSMSReminder($appt_data)
    {
        $apt = new Appointments;
        $appointments = $apt->getAppointments();
        $appts = $appointments->groupBy('phone');
        foreach ($appts as $key => $value) {
            $appt_data = [
                            'phone' => $key,
                            'appts' => $value
                        ];
        $this->send($appt_data);
        }
    }

    private function send($appt_data)
    {
        $msg = 'THIS WEEK\'S APPOINTMENTS REMINDER *-* ';
        foreach ($appt_data['appts'] as $apt) {
            $msg .= ' CLIENT NAME: '.$apt->client->name.', APPOINTMENT TYPE: '.ucfirst($apt->type).', DATE: '.Carbon::parse($apt->appt_date)->format('l jS \of F Y').' *-* ';
            $msg .= ' Please ensure to attend to all your appointments with the clients.';
            }
        $messages = [
            [
                'to' => $appt_data['phone'],
                'message' => $msg
            ],
        ];

        SmsTo::setMessages($messages)->sendSingle();
    }
}
