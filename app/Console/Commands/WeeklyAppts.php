<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\RadetAppt;
use Carbon\Carbon;
use App\Manager;
use App\Http\Controllers\AppointmentController as Appointments;

class WeeklyAppts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'remind:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a weekly reminder to case managers with thier appointments for the week';

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
        $apts = new Appointments;
        $appointments = $apts->getAppointments();//appts for the week beginning

        if (!$appointments->isEmpty()) {
            $appts = $appointments->groupBy('case_manager');
            foreach ($appts as $key => $value) {
                $email = $this->getEmail($key);
                if (empty($email)) {
                    continue;
                }
                $this->sendMailReminder($value, $email, $key);
            }
        }
    }

    private function getEmail($case_manager)
    {
       return Manager::select('email')->where('case_manager', $case_manager)->pluck('email')->first();
    }

    private function sendMailReminder($appt_data, $email, $case_manager)
    {
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.weekly_appts_reminder', ['data'=>$appt_data, 'case_manager'=>$case_manager], function($message) use ($email)
        {
            $message
                ->from('smtp@mailshunt.com','CMAMS - Fhi360')
                ->to($email)
                ->subject('Weekly Pre-appointment Notice');
        });
        return true;
    }
}
