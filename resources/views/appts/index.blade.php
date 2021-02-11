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
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($appointments as $appt)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($appt->appt_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ $appt->case_manager }}</td>
                                        <td>{{ $appt->client_hospital_num }}</td>
                                        <td>{!! ucfirst($appt->appt_type) !!}</td>
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
