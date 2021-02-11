<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Result;
use Carbon\Carbon;

class VlcTurnOver extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vlc:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders to stakeholders for due viral load results';

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
        $results3Days = Result::whereDate('due_date', Carbon::now()->addDays(3))->limit(3)->get();
        $results2Days = Result::whereDate('due_date', Carbon::now()->addDays(2))->limit(3)->get();
        $results1Day = Result::whereDate('due_date', Carbon::now()->addDays(1))->limit(3)->get();

        if (!$results3Days->isEmpty()) {
            $this->sendDue($results3Days, 3);
        }

        if (!$results2Days->isEmpty()) {
            $this->sendDue($results2Days, 2);
        }

        if (!$results1Day->isEmpty()) {
            $this->sendDue($results1Day, 1);
        }
    }

    private function sendDue($results, $days)
    {
        $date = Carbon::now()->addDays($days);

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.due_vlc', ['data'=>$results, 'due_date'=>$date, 'days'=>$days], function($message) use ($results)
        {
            $message
                ->from('smtp@mailshunt.com','Q-MAMS - Fhi360')
                ->to('ekupnse16@gmail.com', 'Ekupnse Cornelius')
                ->cc('pimohi@ahnigeria.org', 'Philip Imohi')
                ->cc('IAbah@ahnigeria.org', 'Ikechukwuka Abah')
                ->cc('bigmikeeneji@gmail.com', 'Michael Eneji')
                ->cc('osanwo@fhi360.org')
                ->cc('spandey@fhi360.org')
                ->cc('cobiora-okafo@fhi360.org')
                ->cc('feyam@ng.fhi360.org', 'Frank Eyam')
                ->cc('cobi@ahnigeria.org', 'Cajetan Obi')
                ->cc('oogieva@ahnigeria.org', 'Osasere Anika')
                ->subject('VL Results TAT Reminder');
        });
        return true;
    }
}
