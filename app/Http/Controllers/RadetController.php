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
use App\BeforeDue;
use App\VLCLookup;
use App\EACList;

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
        return Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))->get();
    }

    public function saveAppointments($todays_radet)
    {

    	foreach ($todays_radet as $appt) {

            if (!empty($appt->last_pickup_date)) {
                //save refill appointments
                if ( Carbon::parse($appt->last_pickup_date)->equalTo( Carbon::parse('2021-01-26') ) ) {
                    $new_appt = new RadetAppt;
                    $new_appt->appt_type            = 'Refill';
                    $new_appt->client_hospital_num  = $appt->client_hospital_num;
                    $new_appt->case_manager         = $appt->case_manager;
                    $new_appt->last_pickup_date     = $appt->last_pickup_date;
                    $new_appt->appt_date           = Carbon::parse($appt->last_pickup_date)->addDays($appt->months_of_refil*30);
                    $new_appt->save();
                }
            }

            // save VL expected VL Results
            if (!empty($appt->date_of_viral_load)) {
                if ( Carbon::parse($appt->date_of_viral_load)->equalTo( Carbon::parse('2021-01-26') ) ) {
                    //save result exp date
                    $result = new Result;
                    $result->due_date = Carbon::parse($appt->date_of_viral_load)->addDays(14);
                    $result->client = $appt->client_hospital_num;
                    $result->facility = $appt->facility;
                    $result->case_manager = $appt->case_manager;
                    $result->save();
                }

                //check for expected results that have returned
                $this->checkVlResult($appt);
            }

            // if (Carbon::parse($appt->art_start_date)->greaterThanOrEqualTo( Carbon::parse('2020-01-01') )) {
            //     if (!empty($appt->date_of_viral_load)) {
            //         $this->setVLCAppt($appt);
            //         $this->checkVlResult($appt);
            //     }
            // } 
    	}

        //alert all EAC Stakeholders
        // $this->checkAlertEAC();

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
                       $today = Carbon::now();
                       // $vlcPointer = 'No';
                       // if ($today->dayOfWeek == Carbon::FRIDAY) {
                       //     $vlcPointer = 'Yes';
                       //     list($vlcEligible, $vlcClients, $vrl_avg) = $this->evalVLC($key);
                       //     $genPerformance['vlc']= $vrl_avg;
                       //     array_push($dailyVLPerf, $vrl_avg);
                       // }else{
                       //     $vlcEligible = 0;
                       //     $vlcClients = 0;
                       //     $vrl_avg = 0;
                       //     array_push($dailyVLPerf, $vrl_avg);
                       // }

                       //TPT Evaluation for the current case manager
                       list($cm_clients, $tpt_clients, $tpt_avg) = $this->evalTPT($key);
                       $genPerformance['tpt']= $tpt_avg;
                       array_push($dailyTPTPerf, $tpt_avg);

		    			//if the current case manager has an appt
			    	    // if ($this->has_refill_appointment_today($key)) {
			    		
			    			//if its a refill appt
			    		if ($this->has_refill_appointment_today($key)) {
                            //set as yes if has refill appt
                            $indicators['Refill'] = 'Yes';
			    			//get the cm's appts
			    			$matchThese = ['case_manager' => $key, 'appt_type' => 'Refill'];

			    			$appts = RadetAppt::whereDate('appt_date', Carbon::parse('2021-01-26'))
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
			    			 	$client = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
			    			 					->where('client_hospital_num', $appt->client_hospital_num)
			    			 					->first();
			    			 	if (Carbon::parse($client->last_pickup_date)->greaterThan(Carbon::parse($appt->last_pickup_date)) ) {
                                    // && Carbon::parse($client->last_pickup_date)->lessThanOrEqualTo(Carbon::parse($appt->appt_date))
			    			 		array_push($points, 1);

                                    // save before due date appointments
                                    if (Carbon::parse($client->last_pickup_date)->lessThan(Carbon::parse($appt->appt_date))) {
                                        $before = new BeforeDue;
                                        $before->client         = $appt->client_hospital_num;
                                        $before->case_manager   = $key;
                                        $before->facility       = $client->facility;
                                        $before->due_date       = Carbon::parse($appt->appt_date);
                                        $before->returned_date  = Carbon::parse($client->last_pickup_date);
                                        $before->save();
                                    }

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
					    		$genPerformance['refill']= $refill_avg;

					    		//push to daily perf
					    		array_push($dailyRefillPerf, $refill_avg);
			    			}

				    		//empty the points array
				    		$points = [];
				    	}
			    		

			    		if ($this->has_viral_load_appt($key)) {
                            $indicators['VLC'] = 'Yes';
			    			//get the cm's appts
			    			$matchThese = ['case_manager' => $key, 'appt_type' => 'VL Sample Collection'];

			    			$appts = RadetAppt::whereDate('appt_date', Carbon::parse('2021-01-26'))
			    							->where($matchThese)
			    							->get();

			    			$appts_count = $appts->count(); 
                            $indicators['VLC_count'] = $appts_count;
                            $appts_met = 0;
			    			//foreach client in the appoints returned
			    			//check thier current refill data (last pickup) from the radet data
			    			foreach ($appts as $appt) {
			    				//get that client instance from today's radet data
			    			 	$client = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
			    			 					->where('client_hospital_num', $appt->client_hospital_num)
			    			 					->first();

			    			 	if ($this->setVLCAppt($client) ) {
			    			 		array_push($points, 1);
                                    $appts_met++;
			    			 	}else{
			    			 		array_push($points, 0);
			    			 	}
			    			}

                            $indicators['VLC_met'] = $appts_met;

			    			//get average of points
				    		//mult by 100 to get a %
				    		if ($appts_count > 0) {
				    			$vrl_avg = ceil( (array_sum($points)/$appts_count) * 100 );

					    		//push unto general perf
					    		$genPerformance['vlc'] = $vrl_avg;

					    		//push to daily perf
					    		array_push($dailyVLPerf, $vrl_avg);
				    		}

                            $points = [];
			    		}

                       //Attendance Evaluation
                       $attendance = Attendance::whereDate('created_at', Carbon::today())->get();
                       $indicators['attendance'] = 'No';
                       foreach ($attendance as $att) {
                            // $coordFac = Coordinate::where('facility',$att->facility)->first();
                            // $coord = $coordFac->longitude.', '.$coordFac->latitude;
                           if ($att->case_manager == $key) {
                            // push 100% to general performance for verfied attendance
                               $genPerformance['att']= 100;
                               // array_push($dailyVLPerf, 1);
                               $indicators['attendance'] = 'Yes';
                           }else{
                                $genPerformance['att']= 0;
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
                            'created_at'   => '2021-01-26 08:47:30'
			    		]);
			    		
                        //build array to hold indicator performances
                        $indcArr = [
                            'refill'       => array_key_exists('Refill', $indicators) ? $indicators['Refill']:'No',
                            'refill_exp'   => array_key_exists('Refill', $indicators) ? $indicators['Refill_count']:0,
                            'refill_met'   => array_key_exists('Refill', $indicators) ? $indicators['Refill_met']:0,
                            'refill_pc'    => array_key_exists('Refill', $indicators) ? $refill_avg: 0, 
                            'vlc'          => array_key_exists('VLC', $indicators) ? $indicators['VLC']:'No',
                            'vlc_exp'      => array_key_exists('VLC', $indicators) ? $indicators['VLC_count']:0,
                            'vlc_met'      => array_key_exists('VLC', $indicators) ? $indicators['VLC_met']:0,
                            'vlc_pc'       => array_key_exists('VLC', $indicators) ? $vrl_avg: 0,
                            'tpt_exp'      => $cm_clients,
                            'tpt_met'      => $tpt_clients, 
                            'tpt_pc'       => $tpt_avg,
                            'attendance'   => $indicators['attendance'],
                            'case_manager' => $key,
                            'created_at'   => '2021-01-26 08:47:30'
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
        $daily_perf->created_at = '2021-01-26 08:47:30';
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

    	$cm_appts = RadetAppt::whereDate('appt_date', Carbon::parse('2021-01-26'))
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
    	$matchThese = ['case_manager'=>$case_manager, 'appt_type'=> 'VL Sample Collection'];

    	$cm_appts = RadetAppt::whereDate('appt_date', Carbon::parse('2021-01-26'))
    							->where($matchThese)
    							->get();

    	if (!$cm_appts->isEmpty()) {
    		$has_appt = true;
    	}
    	
    	return $has_appt;
    }

    public function getDailyAtt()
    {
    	$atts = Attendance::whereDate('created_at', Carbon::today())->count();
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
        // get case_manager's clients
        $clientsCount = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
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

        $clientsTptCount = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
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

    // private function evalVLC($case_manager)
    // {
    //     $eligibleClients = Radet::whereDate('created_at', Carbon::today())
    //                     ->where('case_manager', $case_manager)
    //                     ->whereDate('art_start_date', '<', Carbon::now()->subMonths(3))
    //                     ->where(function($q){
    //                         $q->where('art_status', 'Active')
    //                             ->orWhere('art_status', 'Active-Restart')
    //                             ->orWhere('art_status', 'Active-Transfer In');
    //                     }) 
    //                     ->count();
    //     // dd($eligibleClients);
    //     if ($eligibleClients < 1) {
    //         return array(0,0,0);
    //     }
       
    //     $validVlcClients = Radet::whereDate('created_at', Carbon::today())
    //                     ->where('case_manager', $case_manager)
    //                     ->whereDate('date_of_current_viral_load', '>=', Carbon::parse('2020-04-01'))
    //                     ->whereDate('art_start_date', '<', Carbon::now()->subMonths(3))
    //                     ->where(function($q){
    //                         $q->where('art_status', 'Active')
    //                             ->orWhere('art_status', 'Active-Restart')
    //                             ->orWhere('art_status', 'Active-Transfer In');
    //                     })
    //                     ->count();
    //                         // dd($validVlcClients);

    //     $viral_load_avg = ceil(($validVlcClients/$eligibleClients)*100);

    //     return array($eligibleClients, $validVlcClients, $viral_load_avg);
    // }

    public function setVLCAppt(Radet $radet)
    {
        $vlc_client = VLCLookup::where('client', $radet->client_hospital_num)->first();
        if ($vlc_client) {
            switch ($vlc_client->current_system_status) {
                case 'new_tld_client':
                    return $this->newTLDClient($vlc_client, $radet);
                    break;

                case 'new_non_tld_client':
                    return $this->newNonTLD($vlc_client, $radet);
                    break;

                case 'sec_lvl_tld':
                    return $this->secondLvlTLD($vlc_client, $radet);
                    break;

                case 'sec_lvl_non_tld':
                    return $this->secondLvlNonTLD($vlc_client, $radet);
                    break;

                case 'yearly':
                    return $this->yearlyClients($vlc_client, $radet);
                    break;

                case 'eac':
                    return $this->eacClient($vlc_client, $radet);
                    break;
                
                default:
                    return $this->newTLDClient($vlc_client, $radet);
                    break;
            }
        //save new vl client
        }else{
            if (Carbon::parse($radet->art_start_date)->equalTo(Carbon::parse('2020-01-26'))) {
                $dateDiff = Carbon::now()->diffInMonths(Carbon::parse($radet->art_start_date));

                if ( $dateDiff >= 12 ){
                    $this->moveToGroup($radet, 'yearly', 12);

                }elseif ($dateDiff >= 6 && $dateDiff < 12) {
                    //the 9 monthers
                    if ($radet->regimen_at_art_start === 'TDF-3TC-DTG') {
                        $this->moveToGroup($radet, 'sec_lvl_tld', 9);
                    }else{
                        $this->moveToGroup($radet, 'sec_lvl_non_tld', 6);
                    }

                }elseif ($dateDiff < 4) {
                    if ($radet->regimen_at_art_start === 'TDF-3TC-DTG') {
                        $this->moveToGroup($radet, 'new_tld_client', 3);   
                    }else{
                        $this->moveToGroup($radet, 'new_non_tld_client', 6);
                    }
                }
            }
        }

        return true;
    }

    public function moveToGroup($radet, $status, $months)
    {
        $vlc = new VLCLookup;
        $vlc->client                  = $radet->client_hospital_num;
        $vlc->art_start_date          = Carbon::parse($radet->art_start_date);
        $vlc->last_sample_collection  = Carbon::parse($radet->date_of_viral_load);
        $vlc->date_of_current_vl      = Carbon::parse($radet->date_of_current_viral_load);
        $vlc->current_vl              = $radet->current_viral_load;
        $vlc->regimen_at_start        = $radet->regimen_at_art_start;
        $vlc->current_regimen_type    = $radet->current_regimen;
        $vlc->last_vl_result          = Carbon::parse($radet->last_vl_result);
        $vlc->current_system_status   = $status;
        $vlc->last_vlc_date           = Carbon::parse($radet->date_of_viral_load);
        $vlc->case_manager            = $radet->case_manager;
        $vlc->facility                = $radet->facility;
        $vlc->result_status           = 'expecting';
        $vlc->save();

        //set next appointment
        $new_appt = new RadetAppt;
        $new_appt->appt_type            = 'VL Sample Collection';
        $new_appt->client_hospital_num  = $radet->client_hospital_num;
        $new_appt->case_manager         = $radet->case_manager;
        $new_appt->last_vl_date         = Carbon::parse($radet->date_of_viral_load);
        $new_appt->appt_date            = Carbon::parse($radet->date_of_viral_load)->addMonths($months);
        $new_appt->save();

        return true;
    }

    //3months
    private function newTLDClient($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                # move client progress on the system
                $vlc_client->last_vlc_date = Carbon::parse($radet->date_of_viral_load);
                $vlc_client->current_system_status = 'sec_lvl_tld';//second level tld client
                $vlc_client->result_status = 'expecting';
                $vlc_client->save();

                //set next appointment
                //subject to change depending on if client is suppressed
                $new_appt = new RadetAppt;
                $new_appt->appt_type            = 'VL Sample Collection';
                $new_appt->client_hospital_num  = $radet->client_hospital_num;
                $new_appt->case_manager         = $radet->case_manager;
                $new_appt->last_vl_date         = Carbon::parse($radet->date_of_viral_load);
                $new_appt->appt_date            = Carbon::parse($radet->date_of_viral_load)->addMonths(9);
                $new_appt->save();

                return true;
            }
        }

        return false;
    }

    // first 6months return
    private function newNonTLD($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                # move client progress on the system
                $vlc_client->last_vlc_date = Carbon::parse($radet->date_of_viral_load);
                $vlc_client->current_system_status = 'sec_lvl_non_tld';//second level non_tld client
                $vlc_client->result_status = 'expecting';
                $vlc_client->save();

                //set next appointment
                $new_appt = new RadetAppt;
                $new_appt->appt_type            = 'VL Sample Collection';
                $new_appt->client_hospital_num  = $radet->client_hospital_num;
                $new_appt->case_manager         = $radet->case_manager;
                $new_appt->last_vl_date         = Carbon::parse($radet->date_of_viral_load);
                $new_appt->appt_date            = Carbon::parse($radet->date_of_viral_load)->addMonths(6);
                $new_appt->save();

                return true;
            }
        }

        return false;
    }

    //9months return
    public function secondLvlTLD($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                if ($this->suppressed($vlc_client)) {
                    $this->setYearly($vlc_client, $radet);
                }else{
                    $this->EAC($vlc_client, $radet);
                }

                return true;
            }
        }

        return false;
    }
    //second 6months
    public function secondLvlNonTLD($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                if ($this->suppressed($vlc_client)) {
                    $this->setYearly($vlc_client, $radet);
                }else{
                    $this->EAC($vlc_client, $radet);
                }

                return true;
            }
        }

        return false;
    }

    // yearly return 
    public function yearlyClients($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                if ($this->suppressed($vlc_client)) {
                    $this->setYearly($vlc_client, $radet);
                }else{
                    $this->EAC($vlc_client, $radet);
                }

                return true;
            }
        }

        return false;
    }

    //3months EAC return 
    public function eacClient($vlc_client, $radet)
    {
        if ($this->active($radet)) {
            if (Carbon::parse($radet->date_of_viral_load)->greaterThan(Carbon::parse($vlc_client->last_vlc_date))) {
                $this->newNonTLD($vlc_client, $radet);//come back after 6months
                return true;
            }
        }

        return false; 
    }

    public function suppressed($client)
    {
        if ($client->current_vl != null && $client->current_vl < 1000) {
            return true;
        }

        return false;
    }

    public function setYearly($vlc_client, $radet)
    {
        # move client progress on the system
        $vlc_client->last_vlc_date = Carbon::parse($radet->date_of_viral_load);
        $vlc_client->current_system_status = 'yearly';
        $vlc_client->result_status = 'expecting';
        $vlc_client->save();

        //set next appointment
        $new_appt = new RadetAppt;
        $new_appt->appt_type            = 'VL Sample Collection';
        $new_appt->client_hospital_num  = $radet->client_hospital_num;
        $new_appt->case_manager         = $radet->case_manager;
        $new_appt->last_vl_date         = Carbon::parse($radet->date_of_viral_load);
        $new_appt->appt_date            = Carbon::parse($radet->date_of_viral_load)->addMonths(12);
        $new_appt->save();

        return true;
    }

    public function EAC($vlc_client, $radet)
    {
        # move client progress on the system
        $vlc_client->last_vlc_date = Carbon::parse($radet->date_of_viral_load);
        $vlc_client->current_system_status = 'eac';
        $vlc_client->result_status = 'eac';
        $vlc_client->save();

        //set next appointment
        $new_appt = new RadetAppt;
        $new_appt->appt_type            = 'VL Sample Collection';
        $new_appt->client_hospital_num  = $radet->client_hospital_num;
        $new_appt->case_manager         = $radet->case_manager;
        $new_appt->last_vl_date         = Carbon::parse($radet->date_of_viral_load);
        $new_appt->appt_date            = Carbon::parse($radet->last_vl_result)->addMonths(3);
        $new_appt->save();

        return true;
    }

    public function checkVlResult($client)
    {
        $vlc_client = VLCLookup::where('client', $client->client_hospital_num)->first();
        if ($vlc_client) {
            if ($vlc_client->result_status === 'expecting') {
                //check if result is back
                if (Carbon::parse($client->last_vl_result)->greaterThan(Carbon::parse($vlc_client->last_vl_result))) {
                    $vlc_client->result_status = 'not-expecting';
                    $vlc_client->current_vl = $client->current_viral_load;
                    $vlc_client->last_vl_result = $client->last_vl_result;
                    $vlc_client->save();

                    // unsuppressed
                    if ($vlc_client->current_vl > 999) {
                        $this->storeEAC($vlc_client);
                        $this->changeToEAC($client, $vlc_client);
                    }
                }
            }
        }

        return true;
    }

    public function changeToEAC($radet, $vlc_client)
    {
        $appt_date = $this->getApptDate($vlc_client);

        //get the already set appointment
        $appt = RadetAppt::where('client_hospital_num', $vlc_client->client)
                          ->whereDate('appt_date', $appt_date)
                          ->where('appt_type', 'VL Sample Collection')
                          ->first();
        //reset appt
        $appt->appt_date = Carbon::parse($radet->last_vl_result)->addMonths(3);
        $appt->save();

        $vlc_client->current_system_status = 'eac';
        $vlc_client->save();

        return true;
    }

    public function storeEAC($vlc_client)
    {
        $eac_client = new EACList;
        $eac_client->client             = $vlc_client->client;
        $eac_client->current_viral_load = $vlc_client->current_vl;
        $eac_client->case_manager       = $vlc_client->case_manager;
        $eac_client->facility           = $vlc_client->facility;
        $eac_client->save();

        return true;
    }

    private function getApptDate($client)
    {
        switch ($client->current_system_status) {
            case 'new_tld_client':
                return Carbon::parse($client->last_vlc_date)->addMonths(3);
                break;

            case 'new_non_tld_client':
                return Carbon::parse($client->last_vlc_date)->addMonths(6);
                break;

            case 'sec_lvl_tld':
                return Carbon::parse($client->last_vlc_date)->addMonths(9);
                break;

            case 'sec_lvl_non_tld':
                return Carbon::parse($client->last_vlc_date)->addMonths(6);
                break;

            case 'yearly':
                return Carbon::parse($client->last_vlc_date)->addMonths(12);
                break;

            case 'eac':
                return Carbon::parse($client->last_vlc_date)->addMonths(3);
                break;
                
            default:
                return Carbon::parse($client->last_vlc_date)->addMonths(3);
                break;
        }
    }

    public function active($client)
    {
        if ($client->art_status === 'Active' || $client->art_status === 'Active-Restart' || $client->art_status === 'Active-Transfer In') {
            return true;
        }

        return false;
    }

    public function checkAlertEAC()
    {
        $todaysEAC = EACList::whereDate('created_at', Carbon::today())->get();
        if (!$todaysEAC->isEmpty()) {

            //send to respective case managers
            $this->alertCaseManagers($todaysEAC);

            //send to other stakeholders
            $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
            $beautymail->send('emails.gen_eac_alert', ['data'=>$todaysEAC], function($message) use ($email)
            {
                $message
                    ->from('smtp@mailshunt.com','CMAMS - Fhi360')
                    ->to('ekupnse16@gmail.com')
                    ->subject('EAC Clients Alert');
            });
        }
    }

    private function alertCaseManagers($todaysEAC)
    {
        $cmEACs = $todaysEAC->groupBy('case_manager');
        foreach ($cmEACs as $key => $value) {
            $case_manager = Manager::where('names', $key)->first();
            if ($case_manager) {
                $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
                $beautymail->send('emails.cm_eac_alert', ['data'=>$value], function($message) use ($case_manager)
                {
                    $message
                        ->from('smtp@mailshunt.com','CMAMS - Fhi360')
                        ->to($case_manager->email)
                        ->to('ekupnse16@gmail.com')
                        ->subject('EAC Clients Alert');
                });
            }
        }
    }

    private function getActiveClients($case_manager)
    {
        // get total active clients
        $matchActive =  ['case_manager' => $case_manager, 'art_status' => 'Active'];
        $matchRestart = ['case_manager' => $case_manager, 'art_status' => 'Active-Restart'];
        $matchIn =       ['case_manager' => $case_manager, 'art_status' => 'Active-Transfer In'];
        // get case_manager's clients
        $active = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
                        ->where($matchActive) 
                        ->count();

        $activeR = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
                        ->where($matchRestart) 
                        ->count();

        $activeTI = Radet::whereDate('created_at', Carbon::parse('2021-01-26 08:47:30'))
                        ->where($matchIn) 
                        ->count();

        return $active+$activeR+$activeTI;
    }
}
