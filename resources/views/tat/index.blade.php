@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>UCTH TAT Records</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{$tats->count() }}</code></b> TAT records for UCTH</span>
                        {{-- <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-record-form">
                            <i class="la la-plus-circle"></i> Add Record</button>
                            <form enctype="multipart/form-data" action="{{ route('patients') }}" method="POST">
                            @csrf
                            <input type="file" name="patients">
                            <input type="submit" value="import">
                        </form>
                    </div> --}}
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        {{-- <th>Facility</th> --}}
                                        <th>Patient Name</th>
                                        <th>Lab No.</th>
                                        <th>Hospital No.</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Test Requested</th>
                                        <th>EID Results (Neg/Pos)</th>
                                        <th>V/L Result (Copies/ml)</th>
                                        <th>Gene Xpert (Neg/Pos)</th>
                                        <th>CD4 Result (cells/µl)</th>
                                        <th>Date Test Requested</th>
                                        <th>TAT 1 in Days</th>
                                        <th>Date Sample Collected</th>
                                        <th>Time Sample Collected</th>
                                        <th>TAT 2 in Days</th>
                                        <th>Sample Pick up Date</th>
                                        <th>Sample Transported/Picked up By</th>
                                        <th>Date Sample Recieved at Lab</th>
                                        <th>TAT 3 in Days</th>
                                        <th>Name of Recieving/Testing Laboratory</th>
                                        <th>Date Samples Tested/Assay Date</th>
                                        <th>TAT 4 in Days</th>
                                        <th>Date Result Released to Facility</th>
                                        <th>TAT 5 in Days</th>
                                        <th>Date Result Recieved at Clinic</th>
                                        <th>TAT 6 in Days</th>
                                        <th>Date Result Entered into Medical record</th>
                                        <th>TAT 7 in Days</th>
                                        <th>Date Patient Notified Result is Ready</th>
                                        <th>TAT 8 in Days</th>
                                        <th>Date Result Given to Patient</th>
                                        <th>Overall TAT in Days</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tats as $tat)
                                    <tr>
                                        {{-- <td>{{ $tat->facility }}</td> --}}
                                        <td>{{ $tat->patient_name }}</td>
                                        <td>{{ $tat->lab_no }}</td>
                                        <td>{{ $tat->hospital_no }}</td>
                                        <td>{{ $tat->sex }}</td>
                                        <td>{{ $tat->age }}</td>
                                        <td>
                                            <select type="text" name="test_type" value="{{ $tat->test_type }}" class="record" data-id="{{ $tat->id }}">
                                                <option value="VL" {{ $tat->test_type==='VL'?'selected':'' }}>VL</option>
                                                <option value="EID" {{ $tat->test_type==='EID'?'selected':'' }}>EID</option>
                                                <option value="CD4" {{ $tat->test_type==='CD4'?'selected':'' }}>CD4</option>
                                                <option value="Gene Xpert" {{ $tat->test_type==='Gene Xpert'?'selected':'' }}>Gene Xpert</option>
                                        </td>
                                        <td>
                                            <input type="text" name="eid_res" value="{{ $tat->eid_res }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="text" name="vl_res" value="{{ $tat->vl_res }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="text" name="gene_xpert_res" value="{{ $tat->gene_xpert_res }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="text" name="cd_4_res" value="{{ $tat->cd_4_res }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_test_requested" value="{{ $tat->date_test_requested }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_test_requested)->format('l jS \of F Y') }}">
                                            {{-- <small>{{ \Carbon\Carbon::parse($tat->date_test_requested)->format('l jS \of F Y') }}</small> --}}
                                        </td>
                                        <td>
                                            <input type="number" name="tat_1" value="{{ $tat->tat_1 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_sample_collected" value="{{ $tat->date_sample_collected }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_sample_collected)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="time_sample_collected" value="{{ $tat->time_sample_collected }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_2" value="{{ $tat->tat_2 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="sample_pickup_date" value="{{ $tat->sample_pickup_date }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->sample_pickup_date)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="text" name="sample_trans_pick_by" value="{{ $tat->sample_trans_pick_by }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_sample_rec_at_lab" value="{{ $tat->date_sample_rec_at_lab }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_sample_rec_at_lab)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_3" value="{{ $tat->tat_3 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="text" name="name_of_rec_testing_lab" value="{{ $tat->name_of_rec_testing_lab }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_samples_tested_assay_test" value="{{ $tat->date_samples_tested_assay_test }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_samples_tested_assay_test)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_4" value="{{ $tat->tat_4 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_released_to_facility" value="{{ $tat->date_res_released_to_facility }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_res_released_to_facility)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_5" value="{{ $tat->tat_5 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_reci_at_clinic" value="{{ $tat->date_res_reci_at_clinic }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_res_reci_at_clinic)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_6" value="{{ $tat->tat_6 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_entered_into_med_record" value="{{ $tat->date_res_entered_into_med_record }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_res_entered_into_med_record)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_7" value="{{ $tat->tat_7 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_patient_notified_res_ready" value="{{$tat->date_patient_notified_res_ready }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_patient_notified_res_ready)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_8" value="{{ $tat->tat_8 }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_given_to_patient" value="{{$tat->date_res_given_to_patient }}" class="record" data-id="{{ $tat->id }}" data-toggle="tooltip" title="{{ \Carbon\Carbon::parse($tat->date_res_given_to_patient)->format('l jS \of F Y') }}">
                                        </td>
                                        <td>
                                            <input type="number" name="overall_tat" value="{{ $tat->overall_tat }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                        <td>
                                            <input type="text" name="remarks" value="{{ $tat->remarks }}" class="record" data-id="{{ $tat->id }}">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $facilities->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- View Facility Modal --}}
       {{--  @foreach($facilities as $facility)
        <div class="modal fade" id="fac{{$facility->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title view-title" id="exampleModalLabel">
                    <i class="la la-hospital"></i> {{$facility->name}}
                </h3>
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
                                            <th>Name of Backstop</th>
                                            <td>{{ $facility->backstop }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. of Case Managers</th>
                                            <td>{{ $facility->caseManagers()->count() }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td>{{$facility->clients()->count()}}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              
            </div>
          </div>
        </div>
        @endforeach --}}

    {{-- Add Record Modal --}}
            <!-- Modal -->
            <div class="modal fade" id="add-record-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add new TAT record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="{{route('tat.single')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="">
                                {{-- <div class="back-arrow"><i class="la la-long-arrow-left"></i></div> --}}
                                  {{--   <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Client Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                   <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Client ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control{{ $errors->has('clientID') ? ' is-invalid' : '' }}" name="clientID" value="{{old('clientID')}}">
                                            @if ($errors->has('clientID'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('clientID') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        {{-- <label for="inputEmail3" class="col-sm-3 col-form-label">Client</label> --}}
                                        <div class="col-sm-12">
                                            <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }} select-or-search" name="client" placeholder="Search Client Name">
                                                <option value="">Search Client Name</option>
                                                @foreach($ps as $p)
                                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('client'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{-- <label for="inputEmail3" class="col-sm-3 col-form-label">Client</label> --}}
                                        <div class="col-sm-12">
                                            <select class="form-control{{ $errors->has('status') ? ' is-invalid' : '' }} select-or-search" name="test_type" placeholder="Test type">
                                                <option value="">Test requested</option>
                                                <option value="EID">EID</option>
                                                <option value="VL">VL</option>
                                                <option value="CD4">CD4</option>
                                                <option value="Gene Xpert">Gene Xpert</option>
                                            </select>
                                            @if ($errors->has('client'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('client') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        {{-- <label for="inputEmail3" class="col-sm-3 col-form-label">Lab No.</label> --}}
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control{{ $errors->has('lab_no') ? ' is-invalid' : '' }}" name="lab_no" value="{{old('phone')}}" placeholder="Lab No">
                                            @if ($errors->has('phone'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Test Request Date</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control{{ $errors->has('date_test_requested') ? ' is-invalid' : '' }}" name="date_test_requested" value="{{old('date_test_requested')}}">
                                            @if ($errors->has('date_test_requested'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('date_test_requested') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    {{-- <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Facility</label>
                                        <div class="col-sm-9">
                                            <select class="form-control{{ $errors->has('facility') ? ' is-invalid' : '' }} select-or-search sel_facility" name="facility" value="{{old('facility')}}" selected="{{old('facility')}}" placeholder="Pick a facility">
                                                <option>...</option>
                                                @foreach($facilities as $fac)
                                                <option value="{{$fac->id}}">{{$fac->name}}</option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('facility'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('facility') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div> --}}
                                    {{-- <img src="{{asset('assets/images/loading.gif')}}" class="loading-img">
                                        <div class="input-group mb-3 col-sm-12">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Assign Case Manager</label>
                                            </div>
                                            <select class="custom-select{{ $errors->has('case_manager') ? ' is-invalid' : '' }} case_managers_select" name="case_manager" selected="{{old('case_manager')}}" id="inputGroupSelect01" title="{{route('find_case_managers')}}" placeholder="Pick a case manager">
                                            </select>
                                            @if ($errors->has('case_manager'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('case_manager') }}</strong>
                                                </span>
                                            @endif
                                        </div> --}}
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                        </div>
                                    </div>
                            </div>
                            </form>
                       </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Add Facility Modal ends --}}

            <style type="text/css">
                .hide-rec{
                    display: none;
                }

                .record{
                    border: 0;
                    background-color: inherit;
                }

                select.record{
                    width: 50px;
                    background-color: inherit;
                }

                input[type="date"].record{
                    width: 125px;
                    background-color: inherit;
                }

                .table.dataTable[class*="table-"] thead th{
                    background-color: #4680ff !important;
                    color: white;
                    font-size: 16px;
                    font-weight: bold;
                }
            </style>
    @endsection
