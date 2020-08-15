@extends('layouts.dashboard')
@section('content')
{{-- @section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection --}}

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{$title}}</h5>
                        <span class="d-block m-t-5">
                            There are a total of <b><code>{{$appointments->count()}}</code></b> appointments due for this week
                        </span>
                        {{-- <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="tooltip" 
                        title="Upload new appointment schedule" onclick="window.location.href='{{route('add-appts')}}}'">
                            <i class="la la-plus-circle"></i> Upload</button> --}}
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                        
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Case Manager</th>
                                        <th>Client</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appt)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($appt->appt_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ $appt->caseManager->name }}</td>
                                        <td>{{ $appt->client->name }}</td>
                                        <td>{!! ucfirst($appt->type) !!}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span data-toggle="modal" data-target="#appt{{$appt->id}}">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View appointment summary">
                                                            <i class="la la-eye"></i>
                                                        </button>
                                                    </span>
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
        @foreach($appointments as $appt)
        <div class="modal fade" id="appt{{$appt->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title appt-view" id="exampleModalLabel">
                    <i class="la la-calendar-check-o"></i> {{ ucfirst($appt->type) }} appointment 
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
                                            <th>Appointment Date:</th>
                                            <td>{{ Carbon\Carbon::parse($appt->appt_date)->format('l jS \of F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Case Manager involved:</th>
                                            <td>{{ $appt->caseManager->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client involved:</th>
                                            <td>{{ $appt->client->name }}</td>
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

    @endsection
