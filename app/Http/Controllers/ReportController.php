<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\CaseManager;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'Daily Reports';
        $reports = Report::latest()->get();
        return view('report.daily',compact('title','reports'));
    }

    /**
     * Get a case manager for report.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCaseManager(Request $request)
    {
        $status = false;
        $suggested = CaseManager::where('name','like','%'.$request->name.'%')->get();
        if ($suggested->count() > 0) {
            $status = true;
        }

        return ['status'=>$status, 'data'=>$suggested];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
         $rules = [
            'case_manager_name'     => ['required', 'string','max:30'],
            'refill_deno'           => ['required', 'integer'],
            'refill_numo'           => ['required', 'integer'],
            'viral_load_deno'       => ['required', 'integer'],
            'viral_load_numo'       => ['required', 'integer'],
            'ict_deno'              => ['required', 'integer'],
            'ict_numo'              => ['required', 'integer'],
            'tpt_numo'              => ['required', 'integer'],
            'tpt_deno'              => ['required', 'integer'],
        ];

        $validator = validator()->make($request->all(), $rules);

        if ($validator->fails()){
            session()->flash('report_valid_fail', true);
            return redirect()->back()->withInput($request->input())->withErrors($validator);
        }
        // $data = [
        //          'case_manager_id'  =>$request->case_manager_id, 
        //          'refill_deno'      =>$request->request->refill_deno, 
        //          'refill_numo'      =>$request->request->refill_numo,
        //          'viral_load_deno'  =>$request->viral_load_deno,
        //          'viral_load_numo'  =>$request->viral_load_numo,
        //          'ict_deno'         =>$request->ict_deno,
        //          'facility_id'      =>$request->facility,
        //          'case_manager_id'  =>$request->case_manager,
        //          'status'           =>$request->status
        //         ];
        Report::create($request->all());
        return redirect(route('daily'))->with('success', 'Report entered succesfully');
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
