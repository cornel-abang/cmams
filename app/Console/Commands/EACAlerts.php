<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\EACList;
use Carbon\Carbon;

class EACAlerts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'eac:alert';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Alert Viral Load Stakeholders about new clients to be started on Enhanced Adherence Counscelling (EAC)';

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
        $newEAC = EACList::whereDate('last_vl_result', '>=', Carbon::parse('2021-01-01'))->get();
        if (!$newEAC->isEmpty()) {
            $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.gen_eac_alert', ['data'=>$newEAC], function($message)
            {
                $message
                    ->from('smtp@mailshunt.com','CMAMS - Fhi360')
                    ->to('ekupnse16@gmail.com')
                    ->subject('EAC Clients Alert');
            });
        }
    }
}
