@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Tracking Reports</h5>
                        <span class="d-block m-t-5">There are a total of <b><code>{{$trackings->count()}}</code></b> tracking report(s) found on the system</span>
                        <button type="button" class="btn btn-info btn-sm add-btn"><i class="la la-plus-circle"></i> Add report</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Case Manager</th>
                                        <th>Client ID</th>
                                        <th>Phone No.</th>
                                        <th>Phone No. (OPC)</th>
                                        <th>Evidence</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($trackings as $tr)
                                    <tr id="de-{{$tr->id}}">
                                        <td>{{$tr->created_at->format('l jS \of F Y')}}</td>
                                        <td>{{$tr->caseManager->name}}</td>
                                        <td>{{$tr->client->clientID}}</td>
                                        <td>{{$tr->client->phone}}</td>
                                        <td>{{$tr->client->opc_phone}}</td>
                                        <td>
                                            @php
                                            $extension = pathinfo(asset('assets/evidences/'.$tr->evidence), PATHINFO_EXTENSION)
                                            @endphp
                                                <div class="row">
                                                 @if($extension == 'mp3' || $extension == 'wav')
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" 
                                                                title="Play evidence" id="play-evid"><i class="la la-play-circle"></i>
                                                        </button>
                                                        <div class="trigger" id="play-wrapper">
                                                            <audio class="evidence-player"controls>
                                                                <source src="{{asset('assets/evidences/'.$tr->evidence)}}" type="audio/{{$extension}}">
                                                            </audio>
                                                            <a href="javascript:void()" class="la la-times-circle cls-player"></a>
                                                        </div>
                                                    </div>
                                                    @elseif($extension == 'jpg')
                                                    <div class="col-md-4">
                                                        <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" 
                                                            title="View evidence" id="view-evid-img" data-img="{{asset('assets/evidences/'.$tr->evidence)}}"><i class="la la-eye"></i>
                                                            </button>
                                                    </div>
                                                @endif
                                                </div>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit tracking info" onclick="window.location.href='{{route('edit-tracking', $tr->id)}}'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#tr{{$tr->id}}">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View report summary">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="{{$tr->id}}" class="btn btn-danger btn-sm delete-btn-tracking" data-toggle="tooltip" title="Delete tracking info">
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
    {{-- View evidence Modal --}}
        @foreach($trackings as $tr)
        <div class="modal fade" id="tr{{$tr->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title tracking_view_header" id="exampleModalLabel">
                    Tracking report: <br>
                    <i class="la la-user"></i> <span class="styled-header">{{$tr->caseManager->name}}</span> 
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
                                            <th>Tracking Date</th>
                                            <td> {{$tr->created_at->format('l jS \of F Y')}} </td>
                                        </tr>
                                        <tr>
                                            <th>Client ID</th>
                                            <td>{{ $tr->client->clientID}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone Number</th>
                                            <td>{{$tr->client->phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Phone OPC</th>
                                            <td>{{$tr->client->opc_phone}}</td>
                                        </tr>
                                        <tr>
                                            <th>Tracking method </th>
                                            <td>{{$tr->method}}</td>
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
    
     <div class="modal fade" id="evidence-view" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-body">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <img src="" class="img-fluid img-thumbnail" id="evidence-img-display">
                <h4 class="tr_img_view">
                    By: <span class="styled-header">{{$tr->caseManager->name}}  <br><i class="badge badge-pill badge-primary cm_tag_track_view">Case Manager</i></span> 
                </h4>
            </div>
          </div>
        </div>
    </div>
    @endsection
