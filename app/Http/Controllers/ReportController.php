<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\CaseManager;
use Carbon\Carbon;
use App\Performance;
use App\RadetPerformance;

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
        $reports = RadetPerformance::whereDate('created_at', Carbon::today())->get();
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
            'comment'               => ['string', 'max:300']
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
        $report = Report::create($request->all());
        $this->savePerformance($report);
        return redirect(route('daily'))->with('success', 'Report entered succesfully');
    }

    public function savePerformance($report)
    {
        $performance = collect([
                    ceil(($report->viral_load_numo / $report->viral_load_deno)*100),
                    ceil(($report->refill_numo / $report->refill_deno)*100),
                    ceil(($report->ict_numo / $report->ict_deno)*100),
                    ceil(($report->tpt_numo / $report->tpt_deno)*100),
                    100
                ])->average();
        $data = ['case_manager_id'=>$report->case_manager_id, 'performance'=>$performance];
        Performance::create($data);
        return true;
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
        $title = 'Edit Report';
        $report = Report::find($id);
        return view('report.edit', compact('title','report'));
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
        $report = Report::find($id);
        $report->update($request->all());
        $report->tag = isset($request->tag)?'on':'off';
        $report->save();
        session()->flash('success','Report updated!');
        return redirect()->route('daily');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $report = Report::find($request->id);
        $report->delete();
        return true;
    }

    public function getReportByDate(Request $request)
    {
        $status = false;
        $reports = Report::where('created_at', 'like', '%'.$request->theDay.'%')->get();
        if ($reports->count() > 0) {
            $status = true;
        }
        if ($request->ajax()) {
         return compact('status','reports');   
        }
        //if request is not ajax
        $title = 'Reports submitted on '.Carbon::parse($request->theDay)->format('l jS \of F Y'); 
        $theDay = $request->theDay;
        return view('report.daily', compact('title', 'reports','theDay'));
    }

    public function getReportByWeek(Request $request)
    {
        $status = false;
        // dd(Carbon::now()->subWeek($request->week)->format('l jS \of F Y'));
        $reports = Report::whereBetween('created_at', [
                            Carbon::now()->startOfWeek(), 
                            Carbon::now()->subWeek(-$request->week)
                        ])->get();
        if ($reports->count() > 0) {
            $status = true;
        }
        if ($request->ajax()) {
         return compact('status','reports');   
        }
        //if request is not ajax
        $title = 'Reports submitted '.$request->week.' week(s) back'; 
        $week = $request->week;
        return view('report.daily', compact('title', 'reports','week'));
    }

     public function getReportByMonth(Request $request)
    {
        $status = false;
        $reports = Report::where('created_at', 'like', '%2020-'.$request->month.'%')->get();
        //set month arrays
        $months = [
                    '01'=>'January', 
                    '02'=>'February', 
                    '03'=>'March', 
                    '04'=>'April', 
                    '05'=>'May', 
                    '06'=>'June', 
                    '07'=>'July', 
                    '08'=>'August', 
                    '09'=>'September', 
                    '10'=>'October', 
                    '11'=>'November', 
                    '12'=>'December'
                ];
        $month = $months["$request->month"];
        if ($reports->count() > 0) {
            $status = true;
        }
        if ($request->ajax()) {
         return compact('status','reports','month');   
        }
        //if request is not ajax
        $title = $month.' reports'; 
        return view('report.daily', compact('title', 'reports','month'));
    }

     public function getReportByYear(Request $request)
    {
        $status = false;
        $reports = Report::where('created_at', 'like', '%'.$request->year.'%')->get();
        if ($reports->count() > 0) {
            $status = true;
        }
        if ($request->ajax()) {
         return compact('status','reports');   
        }
        //if request is not ajax
        $year = $request->year;
        $title = $year.' reports'; 
        return view('report.daily', compact('title','reports','year'));
    }
}
