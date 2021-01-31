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
                            <i class="la la-download"></i> Download Tmesheet</button>
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
                                        <td>{{ \Carbon\Carbon::parse($att->checkoutTime)->format('g:i A') }}</td>
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
    @endsection
