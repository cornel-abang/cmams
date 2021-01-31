@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Registered Facilities</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{ facilityCount() }}</code></b> facilities registered</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-facility-form">
                            <i class="la la-plus-circle"></i> Add Facility</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Facility Name</th>
                                        <th>Backstop</th>
                                        <th>No. of Case Managers</th>
                                        <th>No. of Clients</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($facilities as $facility)
                                    <tr id="de-{{$facility->id}}">
                                        <td>{{$facility->id}}</td>
                                        <td>{{ $facility->name }}</td>
                                        <td>{{$facility->backstop}}</td>
                                        <td>
                                            @if($facility->caseManagers->count() > 0)
                                                <a href="{{route('view_case_managers',$facility->id)}}" data-toggle="tooltip" 
                                                    title="View case managers in {{$facility->name}}">
                                                    {{$facility->caseManagers->count()}}
                                                </a>
                                            @else
                                                {{$facility->caseManagers->count()}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($facility->clients()->count() > 0)
                                                <a href="{{route('view_clients', $facility->id)}}" data-toggle="tooltip" 
                                                    title="View clients in {{$facility->name}}">
                                                    {{$facility->clients()->count()}}
                                                </a>
                                            @else
                                                {{$facility->clients()->count()}}
                                            @endif
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit facility" onclick="window.location.href='{{route('edit-facility',$facility->id)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#fac{{$facility->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View facility">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="{{$facility->id}}" class="btn btn-danger btn-sm delete-btn-facility" data-toggle="tooltip" title="Delete facility"><i class="la la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
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
        @foreach($facilities as $facility)
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
                                            <td>{{ $facility->caseManagers->count() }}</td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td>0</td>
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

    {{-- Add Facility Modal --}}
            <!-- Modal -->
            <div class="modal fade" id="add-facility-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title view-title" id="exampleModalLabel">Register New Facility</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <div class="col-md-12 options">
                                <div class="single-tab"><i class="la la-file-o"> Single Facilty</i></div>
                                <div class="bulk-tab"><i class="la la-files-o"></i> Bulk Upload</div>
                            </div>
                            <form action="{{route('add-facility')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="single-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Facilty Name</label>
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
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Name of Backstop</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control{{ $errors->has('backstop') ? ' is-invalid' : '' }}" name="backstop" value="{{old('backstop')}}">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('backstop') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bulk-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                        <div class="input-group mb-3 col-sm-12">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Upload CSV</label>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input{{ $errors->has('bulk-facility') ? ' is-invalid' : '' }}" id="inputGroupFile01" name="bulk-facility">
                                                 @if ($errors->has('bulk-facility'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('bulk-facility') }}</strong>
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
                                </div>
                            </form>
                       </div>         
                  </div>
                </div>
              </div>
            </div>
            {{-- Add Facility Modal ends --}}
    @endsection
