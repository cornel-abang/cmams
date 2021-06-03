<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\RadetAppt;
use Carbon\Carbon;
use App\CaseManager;
use App\Result;
use App\BeforeDue;
use App\MetAppt;
use App\MissedAppt;
use App\Exports\BeforeDueExport;
use App\Exports\BeforeDueFutureExport;
use App\Exports\MetApptsExport;
use App\Exports\MissedApptsExport;
use Maatwebsite\Excel\Facades\Excel;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */  
    public function index()
    {
        // $appts_19 = BeforeDue::where('due_date', Carbon::parse('2021-04-19'))->get();
        // dd($appts_19);
        // foreach ($appts_19 as $appt) {
        //     $appt->delete();
        // }
        // dd($appts_19);
        // $appts_19 = RadetAppt::whereBetween('appt_date', 
        //                 [
        //                     Carbon::parse('2021-04-19'), 
        //                     Carbon::parse('2021-04-25')
        //                 ])->where('appt_type', 'Refill')->count();
        // dd($appts_19);
        // $mets = MetAppt::whereBetween('due_date', 
        //                 [
        //                     Carbon::parse('2021-04-19'), 
        //                     Carbon::parse('2021-04-25')
        //                 ])->count();

        // $befores = BeforeDue::whereBetween('due_date', 
        //                 [
        //                     Carbon::parse('2021-04-19'), 
        //                     Carbon::parse('2021-04-25')
        //                 ])->count();

        // dd($mets+$befores);


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
        return RadetAppt::orderBy('appt_date','asc')->whereBetween('appt_date', 
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
        $vlcs = Result::orderBy('due_date','asc')->whereBetween('due_date', 
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

    public function beforeDue()
    {
        $title = 'Clients early to appointments - PAST';
        $befores = BeforeDue::where('due_date', Carbon::yesterday())
                            ->where('returned_date', '<', Carbon::yesterday())
                            ->get();
        return view('appts.before_due', compact('title', 'befores'));
    }

    public function beforeDueFuture()
    {
        $title = 'Clients early to appointments - FUTURE';
        $befores = BeforeDue::where('due_date', '>', Carbon::yesterday())
                        ->where('returned_date', Carbon::yesterday())
                        ->get();
        return view('appts.before_due_future', compact('title', 'befores'));
    }

    public function metAppts()
    {
        $title = 'Met appointments';
        $mets = MetAppt::orderBy('due_date','asc')->whereBetween('due_date', 
                        [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
        return view('appts.met', compact('title', 'mets'));
    }

    public function missedAppts()
    {
        $title = 'Missed appointments';
        $misseds = MissedAppt::orderBy('appt_date','asc')->whereBetween('appt_date', 
                        [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->endOfWeek()
                        ])->get();
        return view('appts.missed', compact('title', 'misseds'));
    }

    public function exportBeforeDuePast()
    {  
        $today = Carbon::yesterday()->toDateString();
        return Excel::download(new BeforeDueExport(), $today.'_Refill_Before_Due_Appts_PAST.xlsx');
    }

    public function exportBeforeDueFuture() 
    {
        $today = Carbon::yesterday()->toDateString();
        return Excel::download(new BeforeDueFutureExport(), $today.'_Refill_Before_Due_Appts_FUTURE.xlsx');
    }

    public function exportMetAppts() 
    {
        $today = Carbon::yesterday()->toDateString();
        return Excel::download(new MetApptsExport(), $today.'_Refill_Met_Appointments.xlsx');
    }

    public function exportMissedAppts() 
    {
        $today = Carbon::yesterday()->toDateString();
        return Excel::download(new MissedApptsExport(), $today.'_Refill_Missed_Appointments.xlsx');
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
