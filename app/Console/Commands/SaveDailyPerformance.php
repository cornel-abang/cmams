<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Report;
use App\DailyPerformance;
use App\CaseManager;
use Carbon\Carbon;
use App\Tracking;

class SaveDailyPerformance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'save:daily_performance';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Save the overall daily performance of case managers based on each indicator';

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
        $reports = Report::whereDate('created_at',Carbon::today())->get();
        if ($reports->count() > 0) {
        //get no of case managers 
        //to determine attendance performance
        $case_mg = CaseManager::all();
        // Get the total refill percentage for the day
        $refill_array = [];
        foreach ($reports as $report) {
            $res = ceil(($report->refill_numo/$report->refill_deno)*100);
            array_push($refill_array, $res);
        }
        $refill_percentage = ceil(collect($refill_array)->average());

         // Get the total attendance percentage for the day
        $attendance_percentage = ceil( ($reports->count()/$case_mg->count())*100 );

        // Get the total viral load percentage for the day
        $viral_load_array = [];
        foreach ($reports as $report) {
            $res = ceil(($report->viral_load_numo/$report->viral_load_deno)*100);
            array_push($viral_load_array, $res);
        }
        $viral_load_percentage = ceil(collect($viral_load_array)->average());

        // Get the total ict percentage for the day
        $ict_array = [];
        foreach ($reports as $report) {
            $res = ceil(($report->ict_numo/$report->ict_deno)*100);
            array_push($ict_array, $res);
        }
        $ict_percentage = ceil(collect($ict_array)->average());

         // Get the total ict percentage for the day
        $tpt_array = [];
        foreach ($reports as $report) {
            $res = ceil(($report->tpt_numo/$report->tpt_deno)*100);
            array_push($tpt_array, $res);
        }
        $tpt_percentage = ceil(collect($ict_array)->average());

        // Tracking percentage
        $tracking = Tracking::all();
        $tracking_percentage = $tracking->count();

        $data = [
                'refill_performance'        => $refill_percentage,
                'attendance_performance'    => $attendance_percentage,
                'viral_load_performance'    => $viral_load_percentage,
                'ict_performance'           => $ict_percentage,
                'tpt_performance'           => $tpt_percentage,
                'tracking_performance'      => $tracking_percentage
            ];

        DailyPerformance::create($data);
        $this->info('Today\'s performance saved!');
        }else{
            $this->info('No reports found for today');
        }
    }
}
