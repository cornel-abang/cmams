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
        $results2Days = Result::whereDate('due_date', Carbon::now()->addDays(1))->get();
        if (!$results2Days->isEmpty()) {
            $this->sendTwoDaysDue($results2Days);
        }
    }

    private function sendTwoDaysDue($results)
    {
        $date = Carbon::now()->addDays(2);

        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('emails.due_vlc', ['data'=>$results, 'due_date'=>$date], function($message) use ($results)
        {
            $message
                ->from('smtp@mailshunt.com','CMAMS - Fhi360')
                ->to('shupel16@gmail.com')
                ->cc('ekupnse16@gmail.com')
                ->cc('pimohi@ahnigeria.org', 'Philip Imohi')
                ->cc('IAbah@ahnigeria.org', 'Ikechukwuka Abah')
                ->cc('bigmikeeneji@gmail.com', 'Michael Eneji')
                ->subject('Viral Load Due Results Reminder');
        });
        return true;
    }
}
