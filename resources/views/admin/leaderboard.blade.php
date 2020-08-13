@extends('layouts.dashboard')
@section('content')

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{$title}}</h5>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Facility</th>
                                        <th class="text-right">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($perf_data as $perfs)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                        <img src="{{asset('/assets/images/uploads/'.$perfs['image'])}}" 
                                                            alt="cm image" class="img-radius wid-40 align-top m-r-15">
                                                        <div class="d-inline-block">
                                                            <h6 class="leader-name">{{ $perfs['name'] }}</h6>
                                                            <p class="text-muted m-b-0">{{ $perfs['clients'] }} client(s)</p>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $perfs['facility'] }}</td>
                                                <td class="text-right">
                                                    @if( $perfs['performance'] > 69 )
                                                        <label class="badge-pill badge-success">{{ $perfs['performance'] }}</label></td>
                                                    @elseif( $perfs['performance'] > 49 && $perfs['performance'] < 70 )
                                                        <label class="badge-pill badge-primary">{{ $perfs['performance'] }}</label></td>
                                                    @elseif( $perfs['performance'] < 50)
                                                        <label class="badge-pill badge-danger">{{ $perfs['performance'] }}</label></td>
                                                    @endif
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    @endsection
