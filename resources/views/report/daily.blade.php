@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Report area</h5>
                        <span class="d-block m-t-5">
                            A total of <b><code>{{$reports->count()}}</code></b> report(s) 
                            @if(!empty($theDay))
                                found on <b>{{ Carbon\Carbon::parse($theDay)->format('l jS \of F Y') }}</b>
                            @elseif(!empty($week))
                                found from <b>{{ Carbon\Carbon::now()->subWeek($week)->format('l jS \of F Y') }}</b> to date
                            @elseif(!empty($month))
                                found for the month of <b>{{$month}}</b>
                            @else
                                found so far
                            @endif
                            {{-- {!! !empty($theDay) ? ' found on '.Carbon\Carbon::parse($theDay)->format('l jS \of F Y') : 'found so far'  !!}  --}}
                        </span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target=" #add-report-form">
                                    <i class="la la-plus-circle"></i> Add Report
                                </button>
                        {{-- Sorting Area --}}
                        <div class="row">
                            <div class="col-md-2 sort_header">
                                <h5 class="sort-title"><span class="la la-filter"></span> Filter By:</h5>
                            </div>
                            {{-- Sort report by day area --}}
                            <div class="col-md-10">
                                <div class="row">
                                <form action="{{route('reports_by_date')}}" method="post" id="date_sort_form" class="col-md-3">
                                    @csrf
                                    <div class="row date-report-search">
                                        <div class="form-group row sort">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">
                                                   <span class="badge-pill badge-info">Day</span>
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="date" class="form-control" id="report_date" name="theDay" 
                                                    value="{!! !empty($theDay) ? $theDay : now()->toDateString() !!}">
                                                </div>
                                            </div>
                                    </div>
                                </form>
                                {{-- Sort report by weeek --}}
                                <form action="{{route('reports_by_week')}}" method="post" id="week_sort_form" class="col-md-3">
                                    @csrf
                                    <div class="row date-report-search">
                                        <div class="form-group row sort">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">
                                                    <span class="badge-pill badge-info">Week</span>
                                                </label>
                                                <div class="col-sm-7">
                                                    <input type="number" class="form-control" id="report_week" name="week" 
                                                    value="{!! $week ?? '' !!}" placeholder="Enter number of weeks back">
                                                    <small><code>{{ !empty($week)? $week.' week(s) back':''}}</code></small>
                                                </div>
                                            </div>
                                    </div>
                                </form>
                                <form action="{{route('reports_by_month')}}" method="post" id="month_sort_form" class="col-md-3">
                                    @csrf
                                    <div class="row date-report-search">
                                        <div class="form-group row sort">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">
                                                   <span class="badge-pill badge-info">Month</span>
                                                </label>
                                                <div class="col-sm-7">
                                                    <select class="form-control" id="report_month" name="month">
                                                        <option value="">--Select month--</option>
                                                        <option value="01"{{!empty($month) && $month === 'January'?'selected':''}}>
                                                            January
                                                        </option>
                                                        <option value="02"{{!empty($month) && $month === 'Febraury'?'selected':''}}>
                                                            Febraury
                                                        </option>
                                                        <option value="03"{{!empty($month) && $month === 'March'?'selected':''}}>
                                                            March
                                                        </option>
                                                        <option value="04"{{!empty($month) && $month === 'April'?'selected':''}}>
                                                            April
                                                        </option>
                                                        <option value="05"{{!empty($month) && $month === 'May'?'selected':''}}>
                                                            May
                                                        </option>
                                                        <option value="06"{{!empty($month) && $month === 'June'?'selected':''}}>
                                                            June
                                                        </option>
                                                        <option value="07"{{!empty($month) && $month === 'July'?'selected':''}}>
                                                            July
                                                        </option>
                                                        <option value="08"{{!empty($month) && $month === 'August'?'selected':''}}>
                                                            August
                                                        </option>
                                                        <option value="09"{{!empty($month) && $month === 'September'?'selected':''}}>
                                                            September
                                                        </option>
                                                        <option value="10"{{!empty($month) && $month === 'October'?'selected':''}}>
                                                            October
                                                        </option>
                                                        <option value="11"{{!empty($month) && $month === 'November'?'selected':''}}>
                                                            November
                                                        </option>
                                                        <option value="12"{{!empty($month) && $month === 'December'?'selected':''}}>
                                                            December
                                                        </option>
                                                    </select>
                                                    <small><code>{{ !empty($month) ? $month.' reports':''}}</code></small>
                                                </div>
                                            </div>
                                    </div>
                                </form>

                                <form action="{{route('reports_by_year')}}" method="post" id="year_sort_form" class="col-md-3">
                                    @csrf
                                    <div class="row date-report-search">
                                        <div class="form-group row sort">
                                                <label for="inputEmail3" class="col-sm-4 col-form-label">
                                                    <span class="badge-pill badge-info">Year</span>
                                                </label>
                                                <div class="col-sm-7">
                                                    <select class="form-control" id="report_year" name="year">
                                                        <option value="">--Select year--</option>
                                                        <option value="2019"{{!empty($year) && $year === 2019 ?'selected':''}}>
                                                            2019
                                                        </option>
                                                        <option value="2020"{{!empty($year) && $year === 2020 ?'selected':''}}>
                                                            2020
                                                        </option>
                                                    </select>
                                                    <small><code>{{ !empty($year) ? $year.' reports':'2020 reports'}}</code></small>
                                                </div>
                                            </div>
                                    </div>
                                </form>
                                </div>
                            </div>
                            {{-- Sorting ends --}}
                        </div>
                    </div>
 
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Case Manager</th>
                                        <th>Attendance</th>
                                        <th>Performance</th>
                                        {{-- <th>Viral Load</th> --}}
                                        {{-- <th>ICT</th>
                                        <th>TPT</th>
                                        <th>Performance</th> --}}
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr id="de-{{$report->id}}">
                                        <td>{{$report->created_at->format('l jS \of F Y') }}</td>
                                        <td>{{$report->case_manager}}</td>
                                        <td>
                                            {{-- @if(__verifyAttendance($report->case_manager, $report->created_at))  --}}
                                            @if($report->indicators->attendance === 'Yes')
                                                <span class="badge-pill badge-success la la-check-circle"> Verified</span>
                                            @else
                                                <span class="badge-pill badge-danger la la-times-circle"> Unverified</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{-- {{ $report->performance }} --}}
                                            @if( $report->performance > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif($report->performance > 49 && 
                                                    $report->performance < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif( $report->performance < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! $report->performance !!}<code>%</code>
                                                </span>
                                        </td>
                                        {{-- 
                                        <td class="{{$score = calcAverage($report)}}">
                                            @if($score > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif($score > 49 && $score < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif($score < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                            {{$score }}<code>%</code>
                                                </span>
                                        </td> --}}
                                        <td>
                                            <div class="row">
                                                {{-- <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit report info" onclick="window.location.href='{{route('edit_report',$report->id)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div> --}}
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#rep{{$report->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View report summary">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="{{$report->id}}" class="btn btn-danger btn-sm delete-btn-report" data-toggle="tooltip" title="Delete report">
                                                        <i class="la la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        {{-- View Facility Modal --}}
        @foreach($reports as $report)
        <div class="modal fade" id="rep{{$report->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title report_view_title" id="exampleModalLabel">
                    <i class="la la-file-alt"></i><span class="styled-header">{{$report->case_manager}}</span> 
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th class="la la-calendar"> {{$report->created_at->format('l jS \of F Y')}}</th>
                                        </tr>
                                        <tr>
                                            <th>Attendance</th>
                                            <td>
                                                {!! $report->indicators->attendance === 'Yes'?'<span class="badge-pill badge-success la la-check-circle"> Verified</span>':'<span class="badge-pill badge-danger la la-times-circle"> Unverified</span>' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refill</th>
                                            <td>
                                                {{ $report->indicators->refill_met }} / {{ $report->indicators->refill_exp }}  
                                                @if($report->indicators->refill_pc > 69)
                                                    <span class="badge-pill badge-success">
                                                @elseif($report->indicators->refill_pc > 49 && 
                                                        $report->indicators->refill_pc < 70)
                                                    <span class="badge-pill badge-info">
                                                @elseif($report->indicators->refill_pc < 50)
                                                    <span class="badge-pill badge-danger">
                                                @endif
                                                    {!! $report->indicators->refill_pc !!}<code>%</code>
                                                    </span><br/>
                                                {!! $report->indicators->refill === 'No'? '<span class="no-appt badge-pill badge-primary">No Refill appointment on this day</span>':'' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Viral Load</th>
                                            <td>
                                                {{ $report->indicators->vlc_met }} / {{ $report->indicators->vlc_exp }}
                                                @if($report->indicators->vlc_exp >= 1)  
                                                    @if($report->indicators->vlc_pc > 69)
                                                        <span class="badge-pill badge-success">
                                                    @elseif($report->indicators->vlc_pc > 49 && 
                                                            $report->indicators->vlc_pc < 70)
                                                        <span class="badge-pill badge-info">
                                                    @elseif($report->indicators->vlc_pc < 50)
                                                        <span class="badge-pill badge-danger">
                                                    @endif
                                                    {!! $report->indicators->vlc_pc !!}<code>%</code>
                                                    </span><br/>
                                                    {!! $report->indicators->vlc_pc >= 90 ? '<span class="no-appt la la-caret-up badge-pill badge-success"> Above the 90% VLC mark</span>':'<span class="badge-pill badge-danger la la-caret-down"> Below the 90% VLC mark</span>' !!}
                                                {{-- @elseif($report->indicators->vlc_exp < 1)
                                                    <span class="badge-pill btn-primary badge-primary">Had no eligible clients on this day</span> --}}
                                                @elseif($report->indicators->vlc == 'No')
                                                    <span class="badge-pill btn-primary badge-primary">No analysis day</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TPT </th>
                                            <td>
                                                {{ $report->indicators->tpt_met }} / {{ $report->indicators->tpt_exp }}  
                                                @if($report->indicators->tpt_pc > 69)
                                                    <span class="badge-pill badge-success">
                                                @elseif($report->indicators->tpt_pc > 49 && 
                                                        $report->indicators->tpt_pc < 70)
                                                    <span class="badge-pill badge-info">
                                                @elseif($report->indicators->tpt_pc < 50)
                                                    <span class="badge-pill badge-danger">
                                                @endif
                                                {!! $report->indicators->tpt_pc !!}<code>%</code>
                                                </span><br/>
                                                {!! $report->indicators->tpt_pc >= 95 ? '<span class="no-appt  la la-caret-up"> Above the 95% TPT mark</span>':'<span class="badge-pill badge-danger la la-caret-down"> Below the 95% TPT mark</span>' !!}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Average Performance</th>
                                            <td class="{{$score = $report->performance }}">
                                            @if($score > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif($score > 49 && $score < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif($score < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                            {{$score }}<code>%</code>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                    {{-- <div class="jumbotron">
                                        <h2 class="la la-comment-medical"></h2><br>
                                        {{$report->comment}}
                                    </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
           </div>
          </div> 
        </div>  
        @endforeach
    </div>
   

 <!-- Modal -->
            <div class="modal fade" id="add-report-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title " id="exampleModalLabel">Add Report </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="{{route('store')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('case_manager_name') ? ' is-invalid' : '' }}" name="case_manager_name" value="{{old('case_manager_name')}}" id="case_manager_name" placeholder="surname firstname middlename">
                                        <table class="appts" id="appts-area">
                                            
                                        </table>
                                        {{-- Case Manager suggestion area --}}
                                        <table class="table table-bordered table-hover">
                                            <tbody id="suggestions" class="cm-suggestions-area">
                                                
                                            </tbody>
                                        </table>
                                        @if ($errors->has('case_manager_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('case_manager_name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                 <input type="hidden" name="case_manager_id" id="case_manager_id" value="{{old('case_manager_id')}}">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Refill</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('refill_deno') ? ' is-invalid' : '' }}" name="refill_deno" value="{{old('refill_deno')}}" placeholder="No. due for refill">
                                        @if ($errors->has('refill_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refill_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('refill_numo') ? ' is-invalid' : '' }}" name="refill_numo" value="{{old('refill_numo')}}" placeholder="No. refilled">
                                        @if ($errors->has('refill_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refill_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">Viral Load</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('viral_load_deno') ? ' is-invalid' : '' }}" name="viral_load_deno" value="{{old('viral_load_deno')}}" placeholder="No. due for collection">
                                        @if ($errors->has('viral_load_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('viral_load_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('viral_load_numo') ? ' is-invalid' : '' }}" name="viral_load_numo" value="{{old('viral_load_numo')}}" placeholder="No. collected">
                                        @if ($errors->has('viral_load_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('viral_load_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">ICT</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('ict_deno') ? ' is-invalid' : '' }}" name="ict_deno" value="{{old('ict_deno')}}" placeholder="No. offered">
                                        @if ($errors->has('ict_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ict_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('ict_numo') ? ' is-invalid' : '' }}" name="ict_numo" value="{{old('ict_numo')}}" placeholder="No. elicited">
                                        @if ($errors->has('ict_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('ict_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-3 col-form-label">TPT</label>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('tpt_deno') ? ' is-invalid' : '' }}" name="tpt_deno" value="{{old('tpt_deno')}}" placeholder="No. eligible">
                                        @if ($errors->has('tpt_deno'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tpt_deno') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="number" class="form-control{{ $errors->has('tpt_numo') ? ' is-invalid' : '' }}" name="tpt_numo" value="{{old('tpt_numo')}}" placeholder="No. offered">
                                        @if ($errors->has('tpt_numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('tpt_numo') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Comment</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{old('comment')}}" placeholder="Comment here.."></textarea>
                                        @if ($errors->has('comment'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('comment') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="custom-control custom-checkbox text-left mb-4 mt-2 featured">
                                    <input type="checkbox" class="custom-control-input" id="customCheck1" name="tag">
                                    <label class="custom-control-label" for="customCheck1">Mark as featured?</label>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                    </div>
                                </div>
                            </form>
                            {{-- <div class="col-md-12 no-match">
                                <h5><span class="fa fa-times-circle"></span> No case manager found</h5><br>
                                <p>Please be sure that your typing the correct name<br>Format: Surname Firstname Middlename</p>
                            </div> --}}
                       </div>         
                  </div>
                </div>
              </div>
            </div>
<style type="text/css">
    .sort label{
        font-size: 9px !important;
        /*color: #00acc1 !important;*/
    }

    .sort_header{
        margin-top: 25px;
    }
</style>


            {{-- Add Facility Modal ends
    
 @endsection 