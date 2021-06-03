<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TATRecord;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TATImport;
use App\Imports\PatientsImport;
use App\Imports\HardResImport;
use App\Imports\SoftResImport;
use App\HardResult;
use App\SoftResult;
use App\PatientList;
use Carbon\Carbon;
use App\Exports\NotSentExport;
use App\Exports\SentExport;

class TATController extends Controller
{
    public function index()
    {
    	$title = 'TAT Tracker';
	    $tats = TATRecord::latest()->limit(100)->get();
	    $ps = PatientList::latest()->limit(50)->get();
	    return view('tat.index', compact('title', 'tats', 'ps'));
    }

    public function saveRecord(Request $request)
    {
    	$record = TATRecord::find($request->id);
    	$record->update([
    		$request->key => $request->val
    	]);

    	return true;
    }

    public function addTAT(Request $request)
    {
    	$client = PatientList::find($request->client);
    	$tat = new TATRecord;
    	$tat->facility = 'University of Calabar Teaching Hospital';
    	$tat->patient_name = $client->name;
    	$tat->lab_no = $request->lab_no;
    	$tat->hospital_no = $client->hospital_num;
    	$tat->sex = $client->sex;
    	$tat->age = Carbon::parse($client->date_of_birth)->diffInYears(Carbon::now());
    	$tat->test_type = $request->test_type;
    	$tat->date_test_requested = Carbon::parse($request->date_test_requested);
    	$tat->save();
 
    	session()->flash('success', 'TAT record created for <b>'.$client->name.'</b>');
    	return redirect()->back();
    }

    public function import(Request $request)
	{
	    $file = $request->file('tat');
	    Excel::import(new TATImport, $file);
	}

	public function importPatients(Request $request)
	{
	    $file = $request->file('patients');
	    Excel::import(new PatientsImport, $file);
	}

    public function showImport()
    {
        $title = 'TAT Results Compared';
        return view('tat.upload_res', compact('title'));
    }

    public function uploadCopies(Request $request)
    {
        $rules = ['soft' => ['required','mimes:csv,txt,xlsx'], 'hard' => ['required','mimes:csv,txt,xlsx'] ];
        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()) {
           return redirect()->back()->withInput($request->input())->withErrors($validator);
        }

        $hardCopies = $request->file('hard');
        $softCopies = $request->file('soft');

        Excel::import(new HardResImport, $hardCopies);
        Excel::import(new SoftResImport, $softCopies);

        $response = $this->compareResults();

        return redirect()->back();
    }

    public function compareResults()
    {
        $hard_copies = HardResult::whereDate('created_at', Carbon::today())->get();
        $soft_copies = SoftResult::whereDate('created_at', Carbon::today())->get();
        
        $sentAlready = [];
        $notSent = [];

        foreach ($hard_copies as $hard_copy) {
            $soft_copy = SoftResult::where('fac_hosp_id', $hard_copy->fac_hosp_id)->first();
            if ($soft_copy) {
                array_push($sentAlready, $soft_copy);
            }else{
                array_push($notSent, $hard_copy);
            }
        }

        // dd($sentAlready, $notSent);

        if (!empty($notSent)) {
            return Excel::download(new NotSentExport($notSent), 'Not Sent Results.xlsx');
        }
        
        if (!empty($sentAlready)) {
            return Excel::download(new SentExport($sentAlready), 'Already Sent Results.xlsx');
        }

        return true;
    }
}
