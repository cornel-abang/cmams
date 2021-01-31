@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{ $title }}</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{managersClients($manager->names)->count()}}</code></b> client(s) assigned to this case manager</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-client-form">
                            <i class="la la-plus-circle"></i> Assign Client</button>
                    </div>
 
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Client ID</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach(managersClients($manager->names) as $client)
                                    <tr id="de-{{$client->id}}">
                                        <td>{{$client->hospital_num}}</td>
                                        <td>{{$client->status}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit client info" onclick="window.location.href='{{route('edit-client',$client->hospital_num)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#cl{{$client->hospital_num}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View client summary">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                               {{--  <div class="col-md-4">
                                                    <button type="button" id="{{$client->id}}" class="btn btn-danger btn-sm delete-btn-client" data-toggle="tooltip" title="Delete client info">
                                                        <i class="la la-trash"></i>
                                                    </button>
                                                </div> --}}
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
        @foreach(managersClients($manager->names) as $client)
        <div class="modal fade" id="cl{{$client->hospital_num}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title client_view_title" id="exampleModalLabel">
                    <i class="la la-user"></i> Client {{$client->hospital_num}} 
                </h4><span class="badge badge-pill badge-info client-status"> {{$client->status}}</span>
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
                                            <th>Client ID</th>
                                            <td>{{$client->hospital_num}}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Facility</th>
                                            <td>{{ $client->facility}}</td>
                                        </tr>
                                        <tr>
                                            <th>Case Manager</th>
                                            <td>{{$client->case_manager}}</td>
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
   

 <!-- Modal -->
            



            {{-- Add Facility Modal ends
    
 @endsection 