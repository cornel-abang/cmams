<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;
use App\CaseManager;
use App\Client;
use App\Report;
use Carbon\Carbon;
use App\DailyPerformance;
use App\Performance;

class DashboardController extends Controller
{
    public function index()
    {
    	$title = 'FHI360 admin area';
    	$facilities 	= Facility::all();
    	$case_managers	= CaseManager::all();
    	$clients		= Client::all();
        $perf_collection    = Performance::orderBy('performance','desc')
                            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->take(5)->get();
        // Group data by case_manager_id so that all similar ids(same case manager)
        // belong together
        $performances = $perf_collection->groupBy('case_manager_id');
        $results = [];
        //loop through the first collection of data
        //each representing a particular case manager
        foreach ($performances as $performance) {
            // initialize an empty array to hold the case manager performances
            // and also create another empty array to use in building a new look 
            // for the case manager data 
            $arr = [];
            $case_mg_data = [];
            // loop through the second instance of the returned data (repin each case manager data)
                foreach($performance as $perf){
                    // get the performance into an array 
                    // average out and create new case manager instance
                    // using the performance avg as key for the final array
                    // so we can order them in a descending order (up-down)
                    array_push($arr, $perf->performance);
                }
            $perf_avg = ceil(collect($arr)->average());
            $case_mg_data = [
                            'name'          =>$perf->caseManager->name,
                            'image'         =>$perf->caseManager->profile_photo,
                            'facility'      =>$perf->caseManager->facility->name,
                            'clients'       =>$perf->caseManager->clients->count(),
                            'performance'   =>$perf_avg
                        ];
            $results[$perf_avg] = collect($case_mg_data);
        }
        //collect final array and sort by keys in descending order
        $top4 = collect($results)->sortKeysDesc();
        $bottom4 = $this->bottomFour();
    	return view('admin.index', compact('title','facilities','case_managers','clients','top4','bottom4'));
    }

    public function getRefillData()
    {
    	$indicators = DailyPerformance::whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    	$refill 	= [];
    	$attendance = [];
    	$viral_load = [];
    	$ict 		= [];
    	$tpt		= [];
    	$tracking	= [];
    	foreach ($indicators as $val) {
    		array_push($refill, $val->refill_performance);
    		array_push($attendance, $val->attendance_performance);
    		array_push($viral_load, $val->viral_load_performance);
    		array_push($ict, $val->ict_performance);
    		array_push($tpt, $val->tpt_performance);
    		array_push($tracking, $val->tracking_performance);
    	}
    	$performance_array = [
    		'refill'	   	=> $refill,
    		'attendance'   	=> $attendance,
    		'viral_load'	=> $viral_load,
    		'ict'			=> $ict,
    		'tpt'			=> $tpt,
    		'tracking'		=> $tracking
    	];
    	return response()->json($performance_array);
    }

    public function leaderboard()
    {
        $title = 'Case Managers Leaderboard';
        $perf_collection    = Performance::orderBy('performance','desc')
                            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
        // Group data by case_manager_id so that all similar ids(same case manager)
        // belong together
        $performances = $perf_collection->groupBy('case_manager_id');
        $results = [];
        //loop through the first collection of data
        //each representing a particular case manager
        foreach ($performances as $performance) {
            // initialize an empty array to hold the case manager performances
            // and also create another empty array to use in building a new look 
            // for the case manager data 
            $arr = [];
            $case_mg_data = [];
            // loop through the second instance of the returned data (repin each case manager data)
                foreach($performance as $perf){
                    // get the performance into an array 
                    // average out and create new case manager instance
                    // using the performance avg as key for the final array
                    // so we can order them in a descending order (up-down)
                    array_push($arr, $perf->performance);
                }
            $perf_avg = ceil(collect($arr)->average());
            $case_mg_data = [
                            'name'          =>$perf->caseManager->name,
                            'image'         =>$perf->caseManager->profile_photo,
                            'facility'      =>$perf->caseManager->facility->name,
                            'clients'       =>$perf->caseManager->clients->count(),
                            'performance'   =>$perf_avg
                        ];
            $results[$perf_avg] = collect($case_mg_data);
        }
        //collect final array and sort by keys in descending order
        $perf_data = collect($results)->sortKeysDesc();
        // dd($perf_data);
        return view('admin.leaderboard', compact('title','perf_data'));
    }
    //function to fetch the bottom four performing case managers
    public function bottomFour()
    {
        $perf_collection    = Performance::orderBy('performance','asc')
                            ->whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->take(4)->get();
        // Group data by case_manager_id so that all similar ids(same case manager)
        // belong together
        $performances = $perf_collection->groupBy('case_manager_id');
        $results = [];
        //loop through the first collection of data
        //each representing a particular case manager
        foreach ($performances as $performance) {
            // initialize an empty array to hold the case manager performances
            // and also create another empty array to use in building a new look 
            // for the case manager data 
            $arr = [];
            $case_mg_data = [];
            // loop through the second instance of the returned data (repin each case manager data)
                foreach($performance as $perf){
                    // get the performance into an array 
                    // average out and create new case manager instance
                    // using the performance avg as key for the final array
                    // so we can order them in a descending order (up-down)
                    array_push($arr, $perf->performance);
                }
            $perf_avg = ceil(collect($arr)->average());
            $case_mg_data = [
                            'name'          =>$perf->caseManager->name,
                            'image'         =>$perf->caseManager->profile_photo,
                            'facility'      =>$perf->caseManager->facility->name,
                            'clients'       =>$perf->caseManager->clients->count(),
                            'performance'   =>$perf_avg
                        ];
            $results[$perf_avg] = collect($case_mg_data);
        }
        //collect final array and sort by keys in descending order
        $performances = collect($results)->sortKeys();
        return $performances;
    }
}
