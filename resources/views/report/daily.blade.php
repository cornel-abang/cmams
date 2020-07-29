@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Daily report area</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{$reports->count()}}</code></b> report(s) today</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-report-form">
                            <i class="la la-plus-circle"></i> Add Report</button>
                    </div>
 
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Case Manager</th>
                                        <th>Attendance</th>
                                        <th>Refill</th>
                                        <th>Viral Load</th>
                                        <th>ICT</th>
                                        <th>TPT</th>
                                        <th>Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr id="de-{{$report->id}}">
                                        <td>{{$report->caseManager->name}}</td>
                                        <td> 1/1 <span class="badge-pill badge-success">{{$report->attendance}}<code>%</code></span></td>
                                        <td>
                                            {{ $report->refill_numo }}/{{ $report->refill_deno }}
                                            @if(ceil(($report->refill_numo / $report->refill_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->refill_numo / $report->refill_deno)*100) > 49 && 
                                                    ceil(($report->refill_numo / $report->refill_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->refill_numo / $report->refill_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->refill_numo / $report->refill_deno)*100) !!}<code>%</code>
                                                </span>
                                        </td>
                                        <td>
                                            {{ $report->viral_load_numo }}/{{ $report->viral_load_deno }}
                                            @if(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) > 49 &&
                                                    ceil(($report->viral_load_numo / $report->viral_load_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                    {!! ceil(($report->viral_load_numo / $report->viral_load_deno)*100) !!}<code>%</code>
                                                </span>
                                        </td>
                                        <td>
                                            {{ $report->ict_numo }}/{{ $report->ict_deno }}
                                            @if(ceil(($report->ict_numo / $report->ict_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->ict_numo / $report->ict_deno)*100) > 49 &&
                                                    ceil(($report->ict_numo / $report->ict_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->ict_numo / $report->ict_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->ict_numo / $report->ict_deno)*100) !!}<code>%</code>
                                            </span>
                                        </td>
                                        <td>
                                           {{ $report->tpt_numo }}/{{ $report->tpt_deno }}
                                            @if(ceil(($report->tpt_numo / $report->tpt_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->tpt_numo / $report->tpt_deno)*100) > 49 &&
                                                    ceil(($report->tpt_numo / $report->tpt_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->tpt_numo / $report->tpt_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->tpt_numo / $report->tpt_deno)*100) !!}<code>%</code>
                                            </span>
                                        </td>
                                        <td>
                                            @php 
                                                $score = collect(
                                                    ceil(($report->viral_load_numo / $report->viral_load_deno)*100),
                                                    ceil(($report->refill_numo / $report->refill_deno)*100),
                                                    ceil(($report->ict_numo / $report->ict_deno)*100),
                                                    ceil(($report->tpt_numo / $report->tpt_deno)*100)
                                                );  
                                            @endphp
                                            @if($score->average() > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif($score->average() > 49 && $score->average() < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif($score->average() < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                            {{$score->average() }}<code>%</code>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit client info" onclick="window.location.href=''"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#rep{{$report->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View client summary">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="{{$report->id}}" class="btn btn-danger btn-sm delete-btn-client" data-toggle="tooltip" title="Delete client info">
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
                    <i class="la la-file-alt"></i> Report by <br><span class="styled-header">{{$report->caseManager->name}}</span> 
                </h4><span class="badge badge-pill badge-info client-status"> {{$report->tag === 'on' ? 'featured':''}}</span>
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
                                            <th>Attendance</th>
                                            <td>
                                                1/1 <span class="badge-pill badge-success">{{$report->attendance}}<code>%</code></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Refill</th>
                                            <td>
                                            {{ $report->refill_numo }}/{{ $report->refill_deno }}
                                            @if(ceil(($report->refill_numo / $report->refill_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->refill_numo / $report->refill_deno)*100) > 49 && 
                                                    ceil(($report->refill_numo / $report->refill_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->refill_numo / $report->refill_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->refill_numo / $report->refill_deno)*100) !!}<code>%</code>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Viral Load</th>
                                            <td>
                                            {{ $report->viral_load_numo }}/{{ $report->viral_load_deno }}
                                            @if(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) > 49 &&
                                                    ceil(($report->viral_load_numo / $report->viral_load_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->viral_load_numo / $report->viral_load_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                    {!! ceil(($report->viral_load_numo / $report->viral_load_deno)*100) !!}<code>%</code>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>ICT</th>
                                            <td>
                                            {{ $report->ict_numo }}/{{ $report->ict_deno }}
                                            @if(ceil(($report->ict_numo / $report->ict_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->ict_numo / $report->ict_deno)*100) > 49 &&
                                                    ceil(($report->ict_numo / $report->ict_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->ict_numo / $report->ict_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->ict_numo / $report->ict_deno)*100) !!}<code>%</code>
                                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TPT </th>
                                            <td>
                                            {{ $report->tpt_numo }}/{{ $report->tpt_deno }}
                                            @if(ceil(($report->tpt_numo / $report->tpt_deno)*100) > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif(ceil(($report->tpt_numo / $report->tpt_deno)*100) > 49 &&
                                                    ceil(($report->tpt_numo / $report->tpt_deno)*100) < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif(ceil(($report->tpt_numo / $report->tpt_deno)*100) < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                                {!! ceil(($report->tpt_numo / $report->tpt_deno)*100) !!}<code>%</code>
                                            </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Performance</th>
                                            <td>
                                            @if($score->average() > 69)
                                                <span class="badge-pill badge-success">
                                            @elseif($score->average() > 49 && $score->average() < 70)
                                                <span class="badge-pill badge-info">
                                            @elseif($score->average() < 50)
                                                <span class="badge-pill badge-danger">
                                            @endif
                                            {{$score->average() }}<code>%</code>
                                            </span>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="jumbotron">
                                        <h2 class="la la-comment-medical"></h2><br>
                                        {{$report->comment}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              {{-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div> --}}
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
                    <h4 class="modal-title add-report-title" id="exampleModalLabel">Add Report </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('case_manager_name') ? ' is-invalid' : '' }}" name="case_manager_name" value="{{old('case_manager_name')}}" id="case_manager_name" placeholder="surname firstname middlename">
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
                                        <input type="number" class="form-control{{ $errors->has('refill-numo') ? ' is-invalid' : '' }}" name="refill_numo" value="{{old('refill-numo')}}" placeholder="No. refilled">
                                        @if ($errors->has('refill-numo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('refill-numo') }}</strong>
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
                                        <textarea class="form-control{{ $errors->has('comment') ? ' is-invalid' : '' }}" name="comment" value="{{old('comment')}}" placeholder="Any comment?"></textarea>
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



            {{-- Add Facility Modal ends
    
 @endsection 