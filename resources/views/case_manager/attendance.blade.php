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
                        <span class="d-block m-t-5">There are a total of <b><code>{{$atts->count()}}</code></b> attendance record(s) so far</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-case-manager-form" onclick="window.location.href='{{ route('timesheets') }}'">
                            <i class="la la-cloud-download-alt"></i> Download Tmesheet</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">

                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Case Manager</th>
                                        <th>Facility</th>
                                        <th>Checked In</th>
                                        <th>Checked Out</th>
                                        <th>Action</th>
                                        <th>Hours Worked</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($atts as $att)
                                    <tr>
                                        <td>{{ $att->created_at->format('l jS \of F Y') }}</td>
                                        <td>{{ $att->case_manager }}</td>
                                        <td>{{ $att->facility }}</td>
                                        <td>{{ \Carbon\Carbon::parse($att->checkInTime)->format('g:i A') }}</td>
                                        <td>
                                            @if(\Carbon\Carbon::parse($att->checkoutTime)->greaterThan($att->checkInTime))
                                                {{ \Carbon\Carbon::parse($att->checkoutTime)->format('g:i A') }}
                                            @else
                                                <span class="badge-pill badge-info">Not checked out</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span id="attImg" data-img="{{ asset('assets/images/uploads/attendance/'.$att->checkInImg) }}" data-cm="{{ $att->case_manager }}" data-time="{{ \Carbon\Carbon::parse($att->checkInTime)->format('l jS \of F Y \@ g:i A') }}">
                                                <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View checkin image">
                                                    <i class="la la-eye"></i>
                                                </button>
                                            </span>  
                                            @if(\Carbon\Carbon::parse($att->checkoutTime)->greaterThan($att->checkInTime))
                                                <span id="attImg" data-img="{{ asset('assets/images/uploads/attendance/'.$att->checkOutImg) }}" data-cm="{{ $att->case_manager }}" data-time={{ \Carbon\Carbon::parse($att->checkoutTime)->format('l jS \of F Y \@ g:i A') }}>
                                                    <button type="button" class="btn btn-warning btn-sm" data-toggle="tooltip" data-placement="top" title="View checkout image">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                            {{-- @else
                                                <span class="badge-pill badge-info">Not checked out</span> --}}
                                            @endif
                                        </td>
                                        <td>{{ gmdate('H:i:s', \Carbon\Carbon::parse($att->checkoutTime)->diffInSeconds($att->checkInTime)) }} -  
                                            <strong>{{ \Carbon\Carbon::parse($att->checkoutTime)->diffInHours($att->checkInTime) }} Hour(s)</strong>
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

        <div class="modal fade" id="att_img_area" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                    <img src="" class="img-fluid img-thumbnail" id="att_img_tag">
                    <h4 class="tr_img_view">
                        <span id="cm_name"></span> <span class="styled-header">  <br><i class="badge badge-pill badge-primary cm_tag_track_view">Case Manager</i></span><br>
                        <span class="la la-clock"> <span id="timestamp"></span></span> 
                    </h4>
                </div>
              </div>
            </div>
        </div>
    @endsection
