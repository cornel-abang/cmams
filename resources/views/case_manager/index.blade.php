@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection



<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Registered Case Managers</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{$case_managers->count()}}</code></b> case manager(s) registered</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-case-manager-form">
                            <i class="la la-plus-circle"></i> Add Case Manager</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">

                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Case Manager Name</th>
                                        <th>Facility</th>
                                        <th>No. of Clients</th>
                                        <th>Avg Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($case_managers as $case_mg)
                                    <tr id="de-{{$case_mg->id}}">
                                        <td>{{$case_mg->id}}</td>
                                        <td>{{$case_mg->names}}</td>
                                        <td>{{$case_mg->facility??'None'}}</td>
                                        <td>
                                            @if($case_mg->clients()->count() > 0)
                                                <a href="{{route('view_clients_cm', $case_mg->id)}}" data-toggle="tooltip"
                                                    title="View clients assigned to {{$case_mg->name}}">
                                                    {{$case_mg->clients()->count()}}
                                                </a>
                                            @else
                                                {{$case_mg->clients()->count()}}
                                            @endif
                                        </td>
                                        <td>
                                            @if(cm_performance($case_mg) > 69)
                                                    <span class="badge-pill badge-success">
                                                @elseif(cm_performance($case_mg) > 49 && 
                                                        cm_performance($case_mg) < 70)
                                                    <span class="badge-pill badge-info">
                                                @elseif(cm_performance($case_mg) < 50)
                                                    <span class="badge-pill badge-danger">
                                            @endif
                                            {{ cm_performance($case_mg) }}%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit case manager" onclick="window.location.href='{{route('edit-case_mg',$case_mg->id)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#mg{{$case_mg->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View case manager">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#ts{{$case_mg->id}}">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View timesheet">
                                                        <i class="la la-calendar-week"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                {{-- <div class="col-md-4">
                                                    <button type="button" id="{{$case_mg->id}}" class="btn btn-danger btn-sm delete-btn-cm" data-toggle="tooltip" title="Delete case manager" ><i class="la la-trash"></i>
                                                    </button>
                                                </div> --}}
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $case_managers->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- View Facility Modal --}}
        @foreach($case_managers as $case_mg)
        <div class="modal fade" id="mg{{$case_mg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title cm_view-title" id="exampleModalLabel">
                    {{-- <i class="la la-briefcase-medical"></i> --}}
                       {{--  <img class="img-radius case-mg-photo-view" src="{{asset('assets/images/uploads/'.$case_mg->profile_photo)}}" alt="User-Profile-Image"> --}}
                        <div class="user-details manager-name">
                            <div id="more-details">{{$case_mg->names}}</div>
                        </div>
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
                                            <th>Email Address</th>
                                            <td>{{ $case_mg->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone No.</th>
                                            <td>{{ $case_mg->phone }}</td>
                                        </tr>
                                        <tr>
                                            <th>Facility</th>
                                            <td>
                                                @if(strlen($case_mg->facility) >= 30)
                                                    {!!substr($case_mg->facility,0,20).' <span style="color: #4680ff;">...</span> '.substr($case_mg->facility,-6)!!}
                                                @else
                                                    {{ $case_mg->facility??'None' }}
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td>
                                                <span class="client-count">{{ $case_mg->clients()->count() }}</span><br/>
                                                <div class="clients-analytica">
                                                    <span class="badge-pill badge-success">Active: {{ clientsAnalyzer($case_mg->names, 'Active') }}</span>
                                                    <br/>
                                                    <span class="badge-pill badge-info">Transferred Out: {{ clientsAnalyzer($case_mg->names, 'Transferred Out') }}</span><br/>
                                                    <span class="badge-pill badge-secondary">IIT: {{ clientsAnalyzer($case_mg->names, 'LTFU') }}</span><br/>
                                                    <span class="badge-pill badge-warning">Stopped: {{ clientsAnalyzer($case_mg->names, 'Stopped') }}</span><br/>
                                                    <span class="badge-pill badge-danger">Dead: {{ clientsAnalyzer($case_mg->names, 'Dead') }}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Avg. Performance</th>
                                            <td>{{ cm_performance($case_mg) }}%</td>
                                        </tr>
                                    </table>
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

        {{-- Timesheet --}}
         @foreach($case_managers as $case_mg)
        <div class="modal fade" id="ts{{$case_mg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title cm_view-title" id="exampleModalLabel">
                    {{-- <i class="la la-briefcase-medical"></i> --}}
                       {{--  <img class="img-radius case-mg-photo-view" src="{{asset('assets/images/uploads/'.$case_mg->profile_photo)}}" alt="User-Profile-Image"> --}}
                        <div class="user-details manager-name">
                            <div id="more-details">{{$case_mg->names}}<br>
                                <em style="font-size: 13px">Work Timesheet</em>
                            </div>
                            <button class="btn btn-info la la-cloud-download-alt" onclick="window.location.href='{{ route('timesheet', $case_mg->id) }}'"> Download</button>
                        </div>
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
                                        @foreach($case_mg->timesheets() as $time)
                                            <tr>
                                                <th>{{ $time->created_at->format('l jS \of F Y') }}</th>
                                                <td>
                                                    @if(\Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) > 0)
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) }} Hour(s)
                                                        </span>
                                                        @else
                                                        <span>
                                                            {{ gmdate('H:i:s', \Carbon\Carbon::parse($time->checkoutTime)->diffInSeconds($time->checkInTime)) }} - 0 Hours
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </table>
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

    {{-- Add Facility Modal --}}
            <!-- Modal -->
            <div class="modal fade" id="add-case-manager-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Register New Case Manager</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="{{route('add-case-manager')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Full Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}" placeholder="surname firstname middlename">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{old('email')}}">
                                        @if ($errors->has('email'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('email') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{old('phone')}}">
                                        @if ($errors->has('phone'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Facility</label>
                                    <div class="col-sm-9">
                                        <select class="form-control{{ $errors->has('facility') ? ' is-invalid' : '' }} select-or-search" name="facility" value="{{old('facility')}}" selected="{{old('facility')}}" placeholder="Pick a facility">
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
                                </div>
                                <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Profile Photo</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input{{ $errors->has('profile_photo') ? ' is-invalid' : '' }}" id="inputGroupFile01" name="profile_photo" required="">
                                             @if ($errors->has('profile_photo'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('profile_photo') }}</strong>
                                            </span>
                                            @endif
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                    </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                    </div>
                                </div>
                            </form>
                       </div>
                  </div>
                </div>
              </div>
            </div>
            {{-- Add Facility Modal ends --}}
    @endsection
