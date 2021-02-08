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
                            A total of <b><code>{{$befores->count()}}</code></b> clients have come in before due date so far.
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
                                        <th>Client</th>
                                        <th>Case Manager Involved</th>
                                        <th>Due Date</th>
                                        <th>Returned Date</th>
                                        <th>Facility</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($befores as $appt)
                                    <tr>
                                        <td>{{ $appt->client }}</td>
                                        <td>{{ $appt->case_manager }}</td>
                                        <td>{{ Carbon\Carbon::parse($appt->due_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($appt->returned_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ $appt->facility }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {{-- {{ $appointments->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>
    </div>

    @endsection
