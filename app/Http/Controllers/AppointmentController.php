<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use Carbon\Carbon;
use App\CaseManager;

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
        // $appts = $appointments->groupBy('email');
        // foreach ($appts as $key => $value) {
        //     $appt_data = [
        //                     'email' => $key,
        //                     'appts' => $value
        //                 ];
        //     $msg = 'THIS WEEK\'S APPOINTMENTS REMINDER *-* ';
        //     foreach ($appt_data['appts'] as $apt) {
        //         $msg .= ' CLIENT NAME: '.$apt->client->name.', APPOINTMENT TYPE: '.ucfirst($apt->type).', DATE: '.Carbon::parse($apt->appt_date)->format('l jS \of F Y').' *-* ';
        //         $msg .= ' Please ensure to attend to all your appointments with the clients.';
        //     }

        //     dd($msg);
        // }
        return view('appts.index',compact('title','appointments')); 
    }

     /**
     * get appointments due this week
     *
     * @return \Illuminate\Http\Response
     */
    public function getAppointments()
    {
        return $appointments = Appointment::orderBy('appt_date','desc')->whereBetween('appt_date', 
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
        $appt_array = $this->csvToArray($file);
        for($i = 0; $i < count($appt_array); $i++){
            Appointment::firstOrCreate($appt_array[$i]);
        }
        session()->flash('success','Appointment data uploaded!');
        return redirect()->route('appointments');
    }

    /**
     * convert a csv to an array 
     * for import into db
     *
     * @return \Illuminate\Http\Response
     */
    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

            $header = null;
            $data = array();
            if (($handle = fopen($filename, 'r')) !== false) {
                while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
                    if (!$header) 
                        $header = $row;
                    else
                        $data[] = array_combine($header, $row);
                }
                fclose($handle);
            }
            return $data;
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
