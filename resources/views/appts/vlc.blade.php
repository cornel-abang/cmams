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
                            There are a total of <b><code>{{$vlcs->count()}}</code></b> Expected Viral Load results this week
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
                                        <th>Due Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($vlcs as $vlc)
                                    <tr>
                                        <td>{{ $vlc->client }}</td>
                                        <td>{{ Carbon\Carbon::parse($vlc->due_date)->format('l jS \of F Y') }}</td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <span data-toggle="modal" data-target="#res{{ $vlc->id }}">
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View summary">
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
                            {{-- {{ $vlcs->links() }} --}}
                        </div>
                    </div>
                </div>
            </div>

            {{-- View Facility Modal --}}
        @foreach($vlcs as $vlc)
        <div class="modal fade" id="res{{$vlc->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">
                    Expected Viral Load Result 
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
                                            <th>Due Date:</th>
                                            <td>{{ Carbon\Carbon::parse($vlc->due_date)->format('l jS \of F Y') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Client involved:</th>
                                            <td>{{ $vlc->client }}</td>
                                        </tr>
                                        <tr>
                                            <th>Facility:</th>
                                            <td>{{ $vlc->facility }}</td>
                                        </tr>
                                         <tr>
                                            <th>Case Manager involved:</th>
                                            <td>{{ $vlc->case_manager }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
        @endforeach 
    </div>

    @endsection
