<?php

use App\Report;
use App\DailyPerformance;
use App\CaseManager;
use Carbon\Carbon;
use App\Tracking;


    /**
     * Daemon script to save daily performance into db
     * This will be done every 24hours=>84,600 seconds.
     *
     * @return int
     */
    /* Remove the execution time limit */ 
    set_time_limit(0);    
	/* Iteration interval in seconds (10 minutes) */ 
	// $sleep_time = 84600;
	$sleep_time = 60;
	while (TRUE) {
		sleep($sleep_time); 
		$reports = Report::whereDate('created_at',Carbon::today())->get();
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
	} 

?>