<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facility;
use App\CaseManager;
use App\Client;
use App\Report;
use Carbon\Carbon;
use App\DailyPerformance;

class DashboardController extends Controller
{
    public function index()
    {
    	$title = 'Admin dashboard';
    	$facilities 	= Facility::all();
    	$case_managers	= CaseManager::all();
    	$clients		= Client::all();
    	return view('admin.index', compact('title','facilities','case_managers','clients'));
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
}
