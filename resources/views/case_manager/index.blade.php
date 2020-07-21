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
                                        <td>{{$case_mg->name}}</td>
                                        <td>{{$case_mg->facility->name}}</td>
                                        <td>
                                            @if($case_mg->clients->count() > 0)
                                                <a href="{{route('view_clients_cm', $case_mg->id)}}" data-toggle="tooltip" 
                                                    title="View clients assigned to {{$case_mg->name}}">
                                                    {{$case_mg->clients->count()}}
                                                </a>
                                            @else
                                                {{$case_mg->clients->count()}}
                                            @endif
                                        </td>
                                        <td>0%</td>
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
                                                    <button type="button" id="{{$case_mg->id}}" class="btn btn-danger btn-sm delete-btn-cm" data-toggle="tooltip" title="Delete case manager" 
                                                        aria-data="{{route('destroy_manager')}}"><i class="la la-trash"></i>
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
        @foreach($case_managers as $case_mg)
        <div class="modal fade" id="mg{{$case_mg->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLabel">
                    {{-- <i class="la la-briefcase-medical"></i> --}}
                        <img class="img-radius case-mg-photo-view" src="{{asset('assets/images/uploads/'.$case_mg->profile_photo)}}" alt="User-Profile-Image">
                        <div class="user-details manager-name">
                            <div id="more-details">{{$case_mg->name}}</div>
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
                                            <th>Facility</th>
                                            <td>{{ $case_mg->facility->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td>0</td>
                                        </tr>
                                        <tr>
                                            <th>Avg. Performamce</th>
                                            <td>0%</td>
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
                                        <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{old('name')}}">
                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('name') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text" for="inputGroupSelect01">Facility</label>
                                        </div>
                                        <select class="custom-select{{ $errors->has('facility') ? ' is-invalid' : '' }}" name="facility" selected="{{old('facility')}}" id="inputGroupSelect01" required>
                                            <option value=""> Choose...</option>
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
                                        <button type="submit" class="btn  btn-primary reg-btn-case-mg">Add</button>
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
