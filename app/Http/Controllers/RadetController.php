<?php

namespace App\Http\Controllers;
ini_set('max_execution_time', 0);

use App\Radet;
use App\RadetAppt;
use Carbon\Carbon;
use App\RadetPerformance;
use App\RadetDailyPerformance;
use Illuminate\Http\Request;
use App\Imports\RadetImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Attendance;
use App\Manager;
use App\Result;
use App\RadetIndicator;

class RadetController extends Controller
{
	public function uploadRadet()
	{
		$title = 'Radet File Upload';
		return view('radet.upload', compact('title'));
	}

    public function importRadetFile(Request $request) 
    {
    	$rules = ['radet-file' => ['required','mimes:csv,txt,xlsx'] ];
        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
           return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $file = $request->file('radet-file');
        Excel::import(new RadetImport, $file);
        $todays_radet = $this->getTodaysRadet();
        //deduce and save the next appointments
        $this->saveAppointments($todays_radet);

        //check for appointments today and do performamce analysis
        // $msg = $this->evalPerformance($todays_radet);

        session()->flash('success', 'Upload complete');
        session()->flash('saved',true);
        return redirect()->back();
    }

    public function getTodaysRadet()
    {
        return Radet::whereDate('created_at', Carbon::today())->get();
    }

    public function saveAppointments($todays_radet)
    {

    	foreach ($todays_radet as $appt) {

            if (!empty($appt->last_pickup_date)) {
                //save refill appointments
                if ( Carbon::parse($appt->last_pickup_date)->equalTo( Carbon::yesterday() ) ) {
                    $new_appt = new RadetAppt;
                    $new_appt->appt_type            = 'Refill';
                    $new_appt->client_hospital_num  = $appt->client_hospital_num;
                    $new_appt->case_manager         = $appt->case_manager;
                    $new_appt->last_pickup_date     = $appt->last_pickup_date;
                    $new_appt->appt_date           = Carbon::parse($appt->last_pickup_date)->addDays($appt->months_of_refil*30);
                    $new_appt->save();
                }

                // save expected VL Results
                if ( Carbon::parse($appt->date_of_viral_load)->equalTo( Carbon::yesterday() ) ) {
                    $result = new Result;
                    $result->due_date = Carbon::parse($appt->date_of_viral_load)->addDays(14);
                    $result->client = $appt->client_hospital_num;
                    $result->facility = $appt->facility;
                    $result->case_manager = $appt->case_manager;
                    $result->save();
                }   
            }
    	}

        return true;
    }

    public function evalPerformance()
    {
        $radet_data = $this->getTodaysRadet();
    	//group radet data by case manager
    	$cmGroup = $radet_data->groupBy('case_manager');

    	//loop through the data 
    	//each loop repin a case manager data
    	// cms for case_managers
    	
    	//initialize daily perf array
    	$dailyRefillPerf = [];
    	$dailyVLPerf = [];
        $dailyTPTPerf = [];

    	//for each case manager
    	foreach ($cmGroup as $key => $value) {
    		// initialize point holder array
	    	$points = [];

	    	//initialize appt count
	    	$appts_count = 0;

	    	//initialize performances
	    	$refill_avg = 0;
	    	$viral_load_avg = 0;
            $tpt_avg = 0;

	    	//initialize gen performance array
	    	$genPerformance = [];

            //appts holder
            $indicators = [];

    		//loop through the radet data
	    	// foreach ($cms as $data) {
	    		//if there's a case_manager assigned
	    		if (!empty($key)) {

                     //VLC Evaluation for current case manager
                       list($vlcEligible, $vlcClients, $vrl_avg) = $this->evalVLC($key);
                       array_push($genPerformance, $vrl_avg);
                       array_push($dailyVLPerf, $vrl_avg);

                       //TPT Evaluation for the current case manager
                       list($cm_clients,$tpt_clients, $tpt_avg) = $this->evalTPT($key);
                       array_push($genPerformance, $tpt_avg);
                       array_push($dailyTPTPerf, $tpt_avg);

		    			//if the current case manager has an appt
			    	// if ($this->has_refill_appointment_today($key)) {
			    		
			    			//if its a refill appt
			    		if ($this->has_refill_appointment_today($key)) {
                            //set as yes if has refill appt
                            $indicators['Refill'] = 'Yes';
			    			//get the cm's appts
			    			$matchThese = ['case_manager' => $key, 'appt_type' => 'Refill'];

			    			$appts = RadetAppt::whereDate('appt_date', Carbon::yesterday())
			    							->where($matchThese)
			    							->get();
			    			
			    			$appts_count = $appts->count(); 
                            $indicators['Refill_count'] = $appts_count;
                            //met appts
                            $appts_met = 0;
			    			//foreach client in the appoints returned
			    			//check thier current refill data (last pickup) from the radet data
			    			foreach ($appts as $appt) {
			    				//get that client instance from today's radet data
			    			 	$client = Radet::whereDate('created_at', Carbon::today())
			    			 					->where('client_hospital_num', $appt->client_hospital_num)
			    			 					->first();
			    			 	if (Carbon::parse($client->last_pickup_date)->greaterThan(Carbon::parse($appt->last_pickup_date)) && Carbon::parse($client->last_pickup_date)->lessThanOrEqualTo(Carbon::parse($appt->appt_date))) {
			    			 		array_push($points, 1);
                                    $this->saveNextRefillAppt($key, $appt->client_hospital_num, $client->last_pickup_date, $client->months_of_refil);
                                    //increment the met appts
                                    $appts_met++;
			    			 	}else{
			    			 		array_push($points, 0);
			    			 	}
			    			}

                            //add met appt count to array
                            $indicators['Refill_met'] = $appts_met;

			    			if ($appts_count > 0) {
				    			#//get average of points
					    		//mult by 100 to get a %
					    		$refill_avg = ceil( (array_sum($points)/$appts_count) * 100 );

					    		//push unto general perf
					    		array_push($genPerformance, $refill_avg);

					    		//push to daily perf
					    		array_push($dailyRefillPerf, $refill_avg);
			    			}

				    		//empty the points array
				    		$points = [];
				    	}
			    		

			    		// if ($this->has_viral_load_appt($key)) {
         //                    $indicators['VLC'] = 'Yes';
			    		// 	//get the cm's appts
			    		// 	$matchThese = ['case_manager' => $key, 'appt_type' => 'Viral Load Collection'];

			    		// 	$appts = RadetAppt::whereDate('appt_date', Carbon::yesterday())
			    		// 					->where($matchThese)
			    		// 					->get();

			    		// 	$appts_count = $appts->count(); 
         //                    $indicators['VLC_count'] = $appts_count;
         //                    $appts_met = 0;
			    		// 	//foreach client in the appoints returned
			    		// 	//check thier current refill data (last pickup) from the radet data
			    		// 	foreach ($appts as $appt) {
			    		// 		//get that client instance from today's radet data
			    		// 	 	$client = Radet::whereDate('created_at', Carbon::today())
			    		// 	 					->where('client_hospital_num', $appt->client_hospital_num)
			    		// 	 					->first();

			    		// 	 	if (Carbon::parse($client->date_of_viral_load)->equalTo( Carbon::yesterday() ) ) {
			    		// 	 		array_push($points, 1);
         //                             $appts_met++;
			    		// 	 	}else{
			    		// 	 		array_push($points, 0);
			    		// 	 	}
			    		// 	}

         //                    $indicators['VLC_met'] = $appts_met;

			    		// 	//get average of points
				    	// 	//mult by 100 to get a %
				    	// 	if ($appts_count > 0) {
				    	// 		$vrl_avg = ceil( (array_sum($points)/$appts_count) * 100 );

					    // 		//push unto general perf
					    // 		array_push($genPerformance, $vrl_avg);

					    // 		//push to daily perf
					    // 		array_push($dailyVLPerf, $vrl_avg);
				    	// 	}

         //                    $points = [];
			    		// }

                       //Attendance Evaluation
                       $attendance = Attendance::whereDate('created_at', Carbon::yesterday())->get();
                       $indicators['attendance'] = 'No';
                       foreach ($attendance as $att) {
                            // $coordFac = Coordinate::where('facility',$att->facility)->first();
                            // $coord = $coordFac->longitude.', '.$coordFac->latitude;
                           if ($att->case_manager === $key) {
                            // push 100% to general performance for verfied attendance
                               array_push($genPerformance, 100);
                               // array_push($dailyVLPerf, 1);
                               $indicators['attendance'] = 'Yes';
                           }else{
                                array_push($genPerformance, 0);
                                // array_push($dailyVLPerf, 0);
                                $indicators['attendance'] = 'No';
                           }
                       }

                      
                       // if ($tpt_avg >= 95) {
                       //     $indicators['TPT'] = 'Good';
                       // }else{
                       //      $indicators['TPT'] = 'Poor';
                       // }

			    		//eval gen perf and save
			    		$perfCollection = collect($genPerformance);
			    		$avg = $perfCollection->average();
			    		
			    		RadetPerformance::create([
			    			'case_manager' => $key,
			    			'performance'  => $avg,
			    		]);
			    		
                        //build array to hold indicator performances
                        $indcArr = [
                            'refill'       => array_key_exists('Refill', $indicators) ? $indicators['Refill']:'No',
                            'refill_exp'   => array_key_exists('Refill', $indicators) ? $indicators['Refill_count']:0,
                            'refill_met'   => array_key_exists('Refill', $indicators) ? $indicators['Refill_met']:0,
                            'refill_pc'    => array_key_exists('Refill', $indicators) ? $refill_avg: 0,
                            'vlc'          => 'Yes',
                            'vlc_exp'      => $vlcEligible,
                            'vlc_met'      => $vlcClients,
                            'vlc_pc'       => $vrl_avg,
                            'tpt_exp'      => $cm_clients,
                            'tpt_met'      => $tpt_clients, 
                            'tpt_pc'       => $tpt_avg,
                            'attendance'   => $indicators['attendance'],
                            'case_manager' => $key
                        ];
                        //save Radet Indicator performances 
                        RadetIndicator::create($indcArr);
		    		// }
	    		}

	    		// break;
	    	// }
    	}

    	//avg the various perf indicators
    	$daily_refill_avg = 0;
    	$daily_vl_avg = 0;
        $daily_tpt_avg = 0;

    	if ($dailyVLPerf) {
    		$daily_vl_avg = array_sum($dailyVLPerf)/count($dailyVLPerf);
    	}

    	if ($dailyRefillPerf) {
    		$daily_refill_avg = array_sum($dailyRefillPerf)/count($dailyRefillPerf);
    	}

        if ($dailyTPTPerf) {
            $daily_tpt_avg = array_sum($dailyTPTPerf)/count($dailyTPTPerf);
        }

    	$daily_perf = new RadetDailyPerformance;
    	$daily_perf->refill_performance = $daily_refill_avg;
    	$daily_perf->viral_load_performance = $daily_vl_avg;
        $daily_perf->tpt_performance = $daily_tpt_avg;
    	$daily_perf->attendance_performance = $this->getDailyAtt();
    	$daily_perf->save();

    	session()->flash('success','Performance evaluation done!');
        return redirect()->route('daily');
    }

    public function saveNextRefillAppt($case_manager, $client, $last_date, $months)
    {
        $new_appt = new RadetAppt;
        $new_appt->appt_type            = 'Refill';
        $new_appt->client_hospital_num  = $client;
        $new_appt->case_manager         = $case_manager;
        $new_appt->last_pickup_date     = $last_date;
        $new_appt->appt_date           = Carbon::parse($last_date)->addDays($months*30);
        $new_appt->save();
    }

    public function  has_refill_appointment_today($case_manager)
    {
    	$has_appt = false;
    	$matchThese = ['case_manager'=>$case_manager, 'appt_type'=> 'Refill'];

    	$cm_appts = RadetAppt::whereDate('appt_date', Carbon::yesterday())
    							->where($matchThese)
    							->get();
                                
    	if (!$cm_appts->isEmpty()) {
    		$has_appt = true;
    	}

    	return $has_appt;
    }

    public function has_viral_load_appt($case_manager)
    {
    	$has_appt = false;
    	$matchThese = ['case_manager'=>$case_manager, 'appt_type'=> 'Viral Load Collection'];

    	$cm_appts = RadetAppt::whereDate('appt_date', Carbon::yesterday())
    							->where($matchThese)
    							->get();

    	if (!$cm_appts->isEmpty()) {
    		$has_appt = true;
    	}
    	
    	return $has_appt;
    }

    public function getDailyAtt()
    {
    	$atts = Attendance::whereDate('created_at', Carbon::yesterday())->count();
    	$cms = Manager::count();

    	if ($cms === 0 || $atts === 0) {
            return 0;
        }
        return ceil( ($atts / $cms) * 100 );
    }

    public function saveDailyPerformance($data)
    {
    	RadetDailyPerformance::create($data);
    	return true;
    }

    private function evalTPT($case_manager)
    {

        // get total active clients
        // stchIn =       ['case_manager' => $case_manager, 'art_status' => 'Active-Transfer In'];
        // get case_manager's clients
        $clientsCount = Radet::whereDate('created_at', Carbon::today())
                        ->where('case_manager', $case_manager)
                        ->where(function($q){
                            $q->where('art_status', 'Active')
                                ->orWhere('art_status', 'Active-Restart')
                                ->orWhere('art_status', 'Active-Transfer In');
                        }) 
                        ->count();
        if ($clientsCount < 1) {
            return array(0,0,0);
        }

                        // dd($clientsCount);

        // get case_manager's clients that have gone through TPT in the last two years
        // $matchTPT = ['case_manager' => $case_manager, 'tpt_in_the_last_2_years' => 'Yes'];
        // $matchActive = ['case_manager' => $case_manager, 'art_status' => 'Active'];
        // $matchRestart = ['case_manager' => $case_manager, 'art_status' => 'Active-Restart'];
        // $matchIn  =      ['case_manager' => $case_manager, 'art_status' => 'Active-Transfer In'];
        // get case_manager's clients
        $clientsTptCount = Radet::whereDate('created_at', Carbon::today())
                        ->where('case_manager', $case_manager)
                        ->where('tpt_in_the_last_2_years', 'Yes')
                        ->where(function($q){
                            $q->where('art_status', 'Active')
                                ->orWhere('art_status', 'Active-Restart')
                                ->orWhere('art_status', 'Active-Transfer In');
                        }) 
                        ->count();

        $tpt_avg = ceil(($clientsTptCount/$clientsCount)*100);

        return array($clientsCount, $clientsTptCount, $tpt_avg);
    }

    private function evalVLC($case_manager)
    {
        // $matchActive = ['case_manager' => $case_manager, 'art_status' => 'Active'];
        // $matchRestart = ['case_manager' => $case_manager, 'art_status' => 'Active-Restart'];
        // $matchIn  =      ['case_manager' => $case_manager, 'art_status' => 'Active-Transfer In'];

        // get the eligible clients for this case_manager
        // $eligibleClients = Radet::whereDate('created_at', Carbon::parse('2021-01-26 15:36:57'))
        //                     ->whereDate('art_start_date', '<', Carbon::now()->subMonths(3))
        //                     ->where($matchActive)
        //                     ->orWhere($matchRestart)
        //                     ->orWhere($matchIn)
        //                     ->count();
        $eligibleClients = Radet::whereDate('created_at', Carbon::today())
                        ->where('case_manager', $case_manager)
                        ->whereDate('art_start_date', '<', Carbon::now()->subMonths(3))
                        ->where(function($q){
                            $q->where('art_status', 'Active')
                                ->orWhere('art_status', 'Active-Restart')
                                ->orWhere('art_status', 'Active-Transfer In');
                        }) 
                        ->count();
        // dd($eligibleClients);
        if ($eligibleClients < 1) {
            return array(0,0,0);
        }
        // get the number which have valid viral load
        // which is date of viral load greater than or equal to: April 2020
        // $validVlcClients = Radet::whereDate('created_at', Carbon::parse('2021-01-26 15:36:57'))
        //                     ->whereDate('art_start_date', '<=', Carbon::now()->subMonths(3))
        //                     ->whereDate('date_of_current_viral_load', '>=', Carbon::parse('2020-04-01'))
        //                     ->where($matchActive)
        //                     ->orWhere($matchRestart)
        //                     ->orWhere($matchIn)
        //                     ->count();
        $validVlcClients = Radet::whereDate('created_at', Carbon::today())
                        ->where('case_manager', $case_manager)
                        ->whereDate('date_of_current_viral_load', '>=', Carbon::parse('2020-04-01'))
                        ->whereDate('art_start_date', '<', Carbon::now()->subMonths(3))
                        ->where(function($q){
                            $q->where('art_status', 'Active')
                                ->orWhere('art_status', 'Active-Restart')
                                ->orWhere('art_status', 'Active-Transfer In');
                        })
                        ->count();
                            // dd($validVlcClients);

        $viral_load_avg = ceil(($validVlcClients/$eligibleClients)*100);

        return array($eligibleClients, $validVlcClients, $viral_load_avg);
    }

    private function getActiveClients($case_manager)
    {
        // get total active clients
        $matchActive =  ['case_manager' => $case_manager, 'art_status' => 'Active'];
        $matchRestart = ['case_manager' => $case_manager, 'art_status' => 'Active-Restart'];
        $matchIn =       ['case_manager' => $case_manager, 'art_status' => 'Active-Transfer In'];
        // get case_manager's clients
        $active = Radet::whereDate('created_at', Carbon::today())
                        ->where($matchActive) 
                        ->count();

        $activeR = Radet::whereDate('created_at', Carbon::today())
                        ->where($matchRestart) 
                        ->count();

        $activeTI = Radet::whereDate('created_at', Carbon::today())
                        ->where($matchIn) 
                        ->count();

        return $active+$activeR+$activeTI;
    }
}
