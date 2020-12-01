<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CaseManager;
use App\Facility;
use App\Client;
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
        $case_managers = CaseManager::orderBy('name','asc')->get();
        return view('case_manager.index', compact('title', 'case_managers','facilities'));
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
                CaseManager::create($data);
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
        $manager = CaseManager::find($id);
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
        $manager = CaseManager::find($id);
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
        $case_manager = CaseManager::find($request->id);
        $case_manager->delete();
        return true;
    }

    public function viewClients($id)
    {
        $manager = CaseManager::find($id);
        $title = 'Clients assigned to '.$manager->name.' facility';
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
        $image = $request->cm_img;  // your base64 encoded
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = time(). '.png';

        Storage::disk('public')->put($imageName, base64_decode($image));
        dd($request->all());
        // $data->photo_name = $photo_name;
        // $data->photo_url = $img_url;
        // $data->save();
    }
}
