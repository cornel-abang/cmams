@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>List of permitted case managers</h5>
                        <span class="d-block m-t-5">A total of <b><code>{{ $p_lists->count() }}</code></b> case managers have been granted attendance permission today.</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-facility-form">
                            <i class="la la-plus-circle"></i> Add List</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Case Manager</th>
                                        <th>Facility</th>
                                        <th>Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($p_lists as $list)
                                    <tr>
                                        <td>{{ $list->case_manager }}</td>
                                        <td>{{ $list->facility }}</td>
                                        <td>{{ $list->reason }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit facility" onclick="window.location.href='{{route('edit-facility')}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#list{{ $list->id }}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View facility">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="" class="btn btn-danger btn-sm delete-btn-facility" data-toggle="tooltip" title="Delete facility"><i class="la la-trash"></i>
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
        @foreach($p_lists as $list)
        <div class="modal fade" id="list{{$list->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title view-title" id="exampleModalLabel">
                    <i class="la la-user"></i> {{$list->case_manager}}
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
                                            <th>Approved By:</th>
                                            <td>{{ $list->approved_by }}</td>
                                        </tr>
                                        <tr>
                                            <th>Reason:</th>
                                            <td>{{ $list->reason }}</td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td>{{ Carbon\Carbon::parse($list->permit_date)->format('l jS \of F Y') }}</td>
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
                    <h3 class="modal-title view-title" id="exampleModalLabel">Add aprroved list</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <div class="col-md-12 options">
                                <div class="single-tab"><i class="la la-file-o"> Single Case Manager</i></div>
                                <div class="bulk-tab"><i class="la la-files-o"></i> Bulk Upload</div>
                            </div>
                            <form action="{{route('add-facility')}}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="single-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control{{ $errors->has('case_manager') ? ' is-invalid' : '' }}" name="case_manager" value="{{old('case_manager')}}">
                                            @if ($errors->has('case_manager'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('case_manager') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Approved By:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control{{ $errors->has('approved_by') ? ' is-invalid' : '' }}" name="approved_by" value="{{old('approved_by')}}">
                                            @if ($errors->has('approved_by'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('approved_by') }}</strong>
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
