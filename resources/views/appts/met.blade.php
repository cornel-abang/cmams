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
                            A total of <b><code>{{$mets->count()}}</code></b> clients have met their appointments so far.
                        </span>
                        <button type="button" class="btn btn-info btn-sm add-btn">
                            <a href="{{route('export-met')}}" style="color: white; font-weight: bold;">
                                <i class="la la-download"></i> Export Today
                            </a>
                        </button>
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
                                    @foreach($mets as $met)
                                    <tr>
                                        <td>{{ $met->client }}</td>
                                        <td>{{ $met->case_manager }}</td>
                                        <td>{{ Carbon\Carbon::parse($met->due_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ Carbon\Carbon::parse($met->returned_date)->format('l jS \of F Y') }}</td>
                                        <td>{{ $met->facility }}</td>
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
