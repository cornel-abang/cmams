<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Manager;
use App\Facility;
use App\Client;
use App\Attendance;
use App\Coordinate;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use App\Permitted;
use App\Imports\ManagerUpdateImport;
use App\Imports\ManagersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class CaseManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Case Managers';
        $facilities = Facility::all();  
        $case_managers = Manager::all();

        return view('case_manager.index', compact('title', 'case_managers','facilities'));
    }

    public function timesheets()
    {
        $atts = $this->getMonthlyAtt();
        $cmAtts = $atts->groupBy('case_manager');
        $sheetsArr = [];

        foreach ($cmAtts as $key => $val) {
            $output = PDF::loadView('case_manager.timesheets', ['atts'=>$val, 'names'=>$key])->setPaper("a4", "portrait")->output();
            
            file_put_contents($key.'_timesheet.pdf', $output);
            $sheetsArr[] = $key.'_timesheet.pdf';
        }

        $month = $atts[0]->created_at->format('F Y');
        return $this->zip_n_Save($sheetsArr, $month);
    }

    public function timesheet($id)
    {
        $cm = Manager::find($id);
        $times = $cm->timesheets();
        if ($times->isEmpty()) {
            session()->flash('error', 'No timesheet found for '.$cm->names.' this month.');
            return redirect()->back();
        }

        $month = $times[0]->created_at->format('F Y');
        $title = $cm->names.' '.$month.' work timesheet';
        $pdf = new PDF;
        $pdf = PDF::loadView('case_manager.timesheet', ['times'=>$times, 'names'=>$cm->names]);
        return $pdf->download($cm->names.'_timesheet.pdf');
    }

    public function permittedList()
    {
        $p_lists = Permitted::all();
        $title = 'List of permitted case managers';
        return view('case_manager.permitted', compact('title', 'p_lists'));
    }

    // private function zip_n_Save(array $sheets, $month)
    // {
    //     $zipname = str_replace(' ', '-', $month.'-timesheets.zip');
    //     $zip = new ZipArchive;
    //     $zip->open(public_path('assets/timesheets/'.$zipname), ZipArchive::CREATE);
    //     // $zip->open($zipname, ZipArchive::CREATE);
    //     foreach ($sheets as $sheet) {
    //         $zip->addFile($sheet);
    //     }      
        

    //     $zip->close();
    //     header('Content-Type: application/zip');
    //     header("Content-Disposition: attachment; filename=".$zipname);
    //     header("Pragma: no-cache"); 
    //     header("Expires: 0");
    //     header('Cache-Control: must-revalidate');
    //     header('Content-Length: ' . filesize($zipname));
    // }

    public function zip_n_Save(array $sheets, $month)
    {
                    // Define Dir Folder
        $public_dir=public_path();
                    // Zip File Name
        $zipFileName = str_replace(' ', '-', $month.'-timesheets.zip');
                    // Create ZipArchive Obj
        $zip = new ZipArchive;
        if ($zip->open($public_dir . '/' . $zipFileName, ZipArchive::CREATE) === TRUE) {
                foreach ($sheets as $sheet) {
                    $zip->addFile($sheet);
                }
                           
            $zip->close();
        }
                    // Set Header
        $headers = array(
                'Content-Type' => 'application/octet-stream',
                'Content-Type'=> 'application/zip',
                'Content-Disposition' => 'attachment; filename='.$zipFileName
        );
        $filetopath=$public_dir.'/'.$zipFileName;
                    // Create Download Response
        return response()->download($filetopath,$zipFileName,$headers);
    }

    private function getMonthlyAtt()
    {
        return Attendance::orderBy('created_at','desc')->whereBetween('created_at', 
                        [
                            Carbon::now()->startOfMonth(), 
                            Carbon::now()->endOfMonth()
                        ])->get();
    }

    public function managersUpload(Request $request)
    {
        $file = $request->file('bulk-cms');
        Excel::import(new ManagersImport, $file);
        return redirect(route('case-managers'))->with('success', 'All Case Managers uploaded');
    }

    public function updateManagers(Request$request)
    {
        $file = $request->file('mg-updates');
        Excel::import(new ManagerUpdateImport, $file);
        return redirect(route('case-managers'))->with('success', 'All Case Managers Updated');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name'           => ['required', 'string', 'max:190'],
            'email'          => ['required', 'string', 'email', 'max:190'],
            'phone'          => ['required', 'digits:11'],
            'facility'       => 'required',
            'profile_photo'  => 'required'
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()){
            session()->flash('case_manager_reg_valid_fail', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        if ($file = $request->file('profile_photo')) {
            $name = $file->getClientOriginalName();
            $storagePath = public_path('/assets/images/uploads/');
            if ($file->move($storagePath, $name)) {
                $data = [
                 'name'             =>$request->name, 
                 'facility_id'      =>$request->facility, 
                 'profile_photo'    =>$name,
                 'email'            => $request->email,
                 'phone'            => $request->phone
                ];
                Manager::create($data);
                return redirect(route('case-managers'))->with('success', 'Case Manager successfully registered');
            }
        }

        return redirect()->back()->withErrors('Please input a valid image file');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
        $manager = Manager::find($id);
        $facilities = Facility::all();
        $title = 'Edit Case Manager: '.$manager->name;
        return view('case_manager.edit', compact('manager', 'title','facilities'));
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
         $rules = [
            'name'           => ['required', 'string', 'max:190'],
            'email'          => ['required', 'string', 'email', 'max:190'],
            'phone'          => ['required', 'digits:11'],
            'facility'       => 'required',
            'profile_photo'  => ['mimes: jpeg, jpg, png']
        ];
        $this->validate($request, $rules);
        $manager = Manager::find($id);
        if ($request->hasFile('profile_photo')) {
                if ($file = $request->file('profile_photo')) {
                    $img_name = $file->getClientOriginalName();
                    $storagePath = public_path('/assets/images/uploads/');
                        if ($file->move($storagePath, $img_name)) {
                            $data =[
                                'name'          => $request->name,
                                'facility'      => $request->facility,
                                'profile_photo' => $img_name
                            ];
                        }
                }
        }else{
                            $data =[
                                'name'          => $request->name,
                                'facility'      => $request->facility,
                            ];
        }

        $manager->update($data);
        return redirect(route('case-managers'))->with('success', 'Case Manager updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $case_manager = Manager::find($request->id);
        $case_manager->delete();
        return true;
    }

    public function viewClients($id)
    {
        $manager = Manager::find($id);
        $title = 'Clients assigned to '.$manager->names;
        return view('case_manager.clients', compact('title','manager'));
    }

     public function search(Request $request)
    {
        $res = false;
        $case_manager = false;
        $client = Client::where('clientID',$request->clientID)
                         ->where('facility_id',$request->facility_id)
                         ->first();
        if ($client) {
            $res = true;
            $case_manager = $client->caseManager->name;
        }
        return ['status'=>$res, 'client'=>$client, 'case_manager'=>$case_manager];
    }

    public function attendance(Request $request)
    {
        // $facility = Coordinate::where('facility', $request->facility)->first();
        // $facility_coord = $facility->longitude.', '.$facility->latitude;
        // if ($request->longitude.', '.$request->latitude !== $facility_coord) {
        //     session()->flash('attendance_not_verified', true);
        //     session()->flash('location', $request->location);
        //     return redirect()->back();
        // }
        $image = $request->cm_img;  // base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time(). '.png';

        // Storage::disk('public')->put($imageName, base64_decode($image));
    
        $storagePath = public_path('/assets/images/uploads/attendance/'.$imageName);
        file_put_contents($storagePath, base64_decode($image));

        $title = 'att_'.$request->case_manager.'_'.Carbon::now()->toDateString();

        $checkedIn = Attendance::where('title',$title)->first();

        if ($checkedIn && Carbon::parse($checkedIn->checkoutTime)->equalTo(Carbon::parse($checkedIn->checkInTime))) {
            $checkedIn->checkoutTime = Carbon::now()->setTimezone('WAT');
            $checkedIn->checkOutImg = $imageName;
            $checkedIn->save();

            session()->flash('case_manager', $request->case_manager);
            session()->flash('checked_out', true);
            return redirect()->back();
        }
        if ($checkedIn && Carbon::parse($checkedIn->checkoutTime)->greaterThan(Carbon::parse($checkedIn->checkInTime))) {
            session()->flash('case_manager', $request->case_manager);
            session()->flash('checked_twice', true);
            return redirect()->back();
        }
        
        $att_time = Carbon::now()->setTimezone('WAT');
        $att = new Attendance;
        $att->title = $title;
        $att->case_manager = $request->case_manager;
        $att->facility = $request->facility;
        $att->coordinates  = $request->longitude.', '.$request->latitude;
        $att->checkInImg = $imageName;
        $att->checkInTime = $att_time;
        $att->save();

        //save checkout time to be equal to checkin time for validation puposes
        $att->checkoutTime = $att_time->subHour(); // For some weird reason, this adds an hour unless you call ->subHour()
        $att->save();

        session()->flash('case_manager', $request->case_manager);
        session()->flash('checked_in', true);
        return redirect()->back();
        // $data->photo_name = $photo_name;
        // $data->photo_url = $img_url;
        // $data->save();
    }

    public function allAttendance()
    {
        $atts = Attendance::orderBy('created_at','desc')->whereBetween('created_at', 
                        [
                            Carbon::now()->startOfMonth(), 
                            Carbon::now()->endOfMonth()
                        ])->get();
        $title = 'Case Managers attendance timesheet';
        return view('case_manager.attendance',compact('title','atts'));
    }

    public function getManagers(Request $request)
    {
        $mgs = Manager::where('facility',$request->facility)->get();
        $success = true;
        if ($mgs->isEmpty()) {
            $success = false;
        }
        return response()->json(['success'=>$success,'managers'=>$mgs]);
    }
}
