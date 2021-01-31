<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\RadetAppt;
use Carbon\Carbon;
use App\CaseManager;
use App\Result;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'This week\'s case manager appointments';
        $appointments = $this->getAppointments();
        return view('appts.index',compact('title','appointments')); 
    }

     /**
     * get appointments due this week
     *
     * @return \Illuminate\Http\Response
     */
    public function getAppointments()
    {
        return RadetAppt::orderBy('appt_date','desc')->whereBetween('appt_date', 
                        [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
    }

    /**
     * get appointments due today
     *
     * @return \Illuminate\Http\Response
     */
    public function getTodyAppts()
    {
        return $appointments = Appointment::where('appt_date', Carbon::now()->today())->get();
    }

    public function vlc()
    {
        $title = 'Viral Load Turnaround Time';
        $vlcs = Result::orderBy('due_date','ASC')->whereBetween('due_date', 
                        [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();

        return view('appts.vlc',compact('vlcs','title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add appointments';
        return view('appts.add',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = ['appt_file'       => ['required','mimes:csv,txt'] ];
        $this->validate($request, $rules);
        $file = $request->file('appt_file');
        // my custom global helper.php function
        $appt_array = csvToArray($file);
        
        for($i = 0; $i < count($appt_array); $i++){
            Appointment::firstOrCreate($appt_array[$i]);
        }
        session()->flash('success','Appointment data uploaded!');
        return redirect()->route('appointments');
    }


    /**
         * Verify that a case manager didnt miss her/her appointment due for 
         * the day a report was submitted
         *
         * @param  int  $id
         * @return \Illuminate\Http\Response
    */
    public function verifyAppt(Request $request)
    {
        $case_mg = CaseManager::find($request->id);
        $appointments = $this->getTodyAppts();
        $appt_arr = [];
        foreach ($appointments as $appt) {
            if ($appt->email === $case_mg->email) {
                $appt_set = [
                            'type'      => $appt->type,
                            'client'    => $appt->client->name
                            ];
                array_push($appt_arr, $appt_set);
            }
        }
        return response()->json($appt_arr);
    }

    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
