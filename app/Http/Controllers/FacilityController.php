<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Datatables;
use Validator;
use App\Facility;
use App\CaseManager;

class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Facilities';
        $facilities = Facility::latest()->get();
        return view('facility.index', compact('title', 'facilities'));
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
            'name'      => ['required', 'string', 'max:190'],
            'backstop'  => ['required', 'string'],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()){
            session()->flash('facility_reg_valid_fail', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        Facility::create($request->all());
        return redirect(route('facilities'))->with('success', 'Facility successfully registered');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $facility = Facility::find($id);
        $title = 'Edit Facilty: '.$facility->name;
        return view('facility.edit-facility', compact('facility', 'title'));
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
            'name'      => ['required', 'string', 'max:190'],
            'backstop'  => ['required', 'string'],
        ];
        $this->validate($request, $rules);
        $facility = Facility::find($id);
        $facility->update($request->all());
        session()->flash('success','Facility Updated');
        return redirect()->route('facilities');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $facility = Facility::find($request->id);
        $facility->delete();
        return true;
    }

    public function viewCaseManagers($id)
    {
        $facility = Facility::find($id);
        $title = 'Case Managers in '.$facility->name.' facility';
        return view('facility.case_managers', compact('title','facility'));
    }

    public function viewClients($id)
    {
        $facility = Facility::find($id);
        $title = 'Clients in '.$facility->name.' facility';
        $managers = CaseManager::where('facility_id',$facility->id)->get();
        return view('facility.clients', compact('title','facility','managers'));
    }
}
