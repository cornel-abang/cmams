@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Clients assigned to {{$manager->name}}</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{$manager->clients->count()}}</code></b> client(s) assigned to this case manager</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-client-form">
                            <i class="la la-plus-circle"></i> Assign Client</button>
                    </div>
 
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Client ID</th>
                                        <th>Client Name</th>
                                        <th>Phone</th>
                                        <th>Facility</th>
                                        <th>Case Manager</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($manager->clients as $client)
                                    <tr id="de-{{$client->id}}">
                                        <td>{{$client->clientID}}</td>
                                        <td>{{$client->name}}</td>
                                        <td>{{$client->phone}}</td>
                                        <td>{{$client->facility->name}}</td>
                                        <td>{{$client->caseManager->name}}</td>
                                        <td>{{$client->status}}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit client info" onclick="window.location.href='{{route('edit-client',$client->id)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#cl{{$client->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View client summary">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="{{$client->id}}" class="btn btn-danger btn-sm delete-btn-client" data-toggle="tooltip" title="Delete client info">
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
        @foreach($manager->clients as $client)
        <div class="modal fade" id="cl{{$client->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">
                    <i class="la la-user"></i> {{$client->name}} 
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
                                            <td>{{ $client->clientID }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client Name</th>
                                            <td>{{ $client->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{$client->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone OPC</th>
                                            <td>{{$client->opc_phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Residential Address </th>
                                            <td>{{$client->address}}</td>
                                        </tr>
                                        <tr>
                                            <th>Facility</th>
                                            <td>{{$client->facility->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Case Manager</th>
                                            <td>{{$client->caseManager->name}}</td>
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
            <div class="modal fade" id="add-client-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Assign client to <span class="styled-header">{{$manager->name}}</span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="{{route('assign-client')}}" method="post">
                                @csrf
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Enter client ID</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control{{ $errors->has('clientID') ? ' is-invalid' : '' }}" name="clientID" id="clientIDSearch" required><img src="{{asset('assets/images/loading.gif')}}" class="loading-img">
                                        @if ($errors->has('clientID'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('clientID') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <input type="hidden" name="facility" value="{{$manager->facility->id}}" id="mg_facility">
                                    <input type="hidden" name="manager_id" value="{{$manager->id}}">
                                </div></div>
                                <div class="form-group row" id="assgnBtnArea">{{-- JbKGNchA3FJ_ --}}
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary assign-btn" >Assign</button>
                                    </div>
                                </div>
                            </form>
                            <div class="col-md-12 no-match">
                                <h5><span class="fa fa-times-circle"></span> No client found</h5><br>
                                <p>Please be sure the client is in the same facility<br> as the case manager</p>
                            </div>
                            <div class="client-info">
                                <div class="card">
                                <div class="card-body">
                                    <h3>Client Info</h3>
                                    <table class="table table-bordered table-striped">
                                        <tr>
                                            <th>Client Name</th>
                                            <td id="clientName"></td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td id="clientPhone"></td>
                                        </tr>
                                        <tr>
                                            <th>Phone OPC</th>
                                            <td id="clientOpc"></td>
                                        </tr>
                                        <tr>
                                            <th>Residential Address </th>
                                            <td id="clientAddress"></td>
                                        </tr>
                                        <tr>
                                            <th>Facility</th>
                                            <td>{{$manager->facility->name}}</td>
                                        </tr>
                                        <tr>
                                            <th>Present Case Manager</th>
                                            <td id="clientCm"></td>
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



            {{-- Add Facility Modal ends
    
 @endsection 