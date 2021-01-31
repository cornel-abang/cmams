@extends('layouts.dashboard')
@section('content')
@section('sweet-alert-area')
    <script src="{{asset('assets/js/sweetalert2.js')}}" defer></script>
@endsection

    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Dashboard Analytics</h5>
                        </div>
                        <ul class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html"><i class="feather icon-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#!">Dashboard Analytics</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <!-- [ Main Content ] start -->
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <!-- support-section start -->
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <hr>
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title">Facilities</h3>
                                <p class="card-text"><h3 class="card-title">{{$facilities->count()}}</h3></p>
                                <a href="{{ route('facilities') }}" class="btn  btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-12 col-md-4">
                        <hr>
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title">Case Managers</h3>
                                <p class="card-text"><h3 class="card-title">{{$case_managers->count()}}</h3></p>
                                <a href="{{ route('case-managers') }}" class="btn  btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-12 col-md-4">
                        <hr>
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title">Clients</h3>
                                <p class="card-text"><h3 class="card-title">{{ number_format(cmCount()) }}</h3></p>
                                <a href="{{ route('clients') }}" class="btn  btn-primary">See all</a>
                                {{-- <form action="{{ route('u-managers') }}" method="post" enctype='multipart/form-data'>
                                    @csrf
                                    <input type="file" name="bulk-cms">
                                    <input type="submit" value="Upload">
                                </form> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <!-- support-section end -->
            </div>

            <!-- prject ,team member start -->
            <div class="col-xl-6 col-md-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5>This week's case managers' leaderboard <span id="set">(Top Performaners)</span></h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><a href="{{ route('leaderboard')}}"><span><i class="feather icon-maximize"></i> See all</span></li>
                                    <li class="dropdown-item"><a href="#!" id="btm-4-nav"><span><i class="feather icon-trending-down"></i> Bottom 4</span></a></li>
                                    <li class="dropdown-item"><a href="#!" id="top-4-nav"><span><i class="feather icon-trending-up"></i> Top 4</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="perf_table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        {{-- <th>Facility</th> --}}
                                        <th class="text-right">Score (%)</th>
                                    </tr>
                                </thead>
                                <tbody id="top4">
                                    @foreach($top4 as $perfs)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                        {{-- <img src="{{asset('/assets/images/uploads/'.$perfs['image'])}}"
                                                            alt="cm image" class="img-radius wid-40 align-top m-r-15"> --}}
                                                        <div class="d-inline-block">
                                                            <h6 class="leader-name">{{ $perfs['name'] }}</h6>
                                                            {{-- <p class="text-muted m-b-0">{{ $perfs['clients'] }} client(s)</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- <td>{{ $perfs['facility'] }}</td> --}}
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
                                    <div class="" id="load"></div>
                                </tbody>
                                <tbody id="bottom4" class="shut">
                                    @foreach($bottom4 as $perfs)
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                       {{--  <img src="{{asset('/assets/images/uploads/'.$perfs['image'])}}"
                                                            alt="cm image" class="img-radius wid-40 align-top m-r-15"> --}}
                                                        <div class="d-inline-block">
                                                            <h6 class="leader-name">{{ $perfs['name'] }}</h6>
                                                            {{-- <p class="text-muted m-b-0">{{ $perfs['clients'] }} client(s)</p> --}}
                                                        </div>
                                                    </div>
                                                </td>
                                                {{-- <td>{{ $perfs['facility'] }}</td> --}}
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
                                    <div class="" id="load"></div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-12">
                <div class="card latest-update-card text-center">
                    <div class="card-header">
                        <h5>KPI Tide Period</h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                {{-- <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button> --}}
                                {{-- <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><a href="{{route('daily')}}"><span><i class="feather icon-maximize"></i> See all</span></a></li>
                                </ul> --}}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            {{-- @foreach($comments as $cm) --}}
                            <div class="row p-t-30 p-b-30">
                               {{--  <div class="col-auto text-right update-meta">
                                    <p class="text-muted m-b-0 d-inline-flex">{{ timeAgo($cm->created_at)}}</p>
                                    <i class="update-icon">
                                        <img class="cm-img" src="{{asset('/assets/images/uploads/'.$cm->caseManager->profile_photo) }}">
                                    </i>
                                </div>
                                <div class="col">
                                    <a href="#!">
                                        <h6>{{ $cm->caseManager->name}}</h6>
                                    </a>
                                    <p class="text-muted m-b-0">{{ $cm->comment }}</p>
                                </div> --}}
                                <span class="week-period" data-lw="{{ $startOfLastWeek = \Carbon\Carbon::now()->subDays(7)->startOfWeek() }}">
                                            Between<br> Last Week ({{ $startOfLastWeek->format('l jS \of F Y') }} - {{ $startOfLastWeek->endOfWeek()->format('l jS \of F Y') }}) & This Week ({{ \Carbon\Carbon::now()->startOfWeek()->format('l jS \of F Y') }} - Till Date)
                                </span>
                            </div>
                            {{-- @endforeach --}}
                        </div>
                        {{-- <div class="text-center">
                            <a href="#!" class="b-b-primary text-primary">View all Projects</a>
                        </div> --}}
                    </div>
                </div>
            </div>
            <!-- prject ,team member start -->
            <!-- performance analysis starts -->
            <div class="col-xl-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-12" id="performance-chart">
                            {{-- Chart Area --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-md-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekRefillAvg() }}%</h4>
                                        <h6 class="text-muted m-b-0">Refill</h6><br/><br/>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="icofont icofont-pills f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="refill-area">
                                    <div class="col-9">
                                         <p class=" m-b-0" id="refill-pointer"
                                            data-val="{{performanceDiff( 'refill_performance', getWeekRefillAvg())}}">
                                            {{ performanceDiff( 'refill_performance', getWeekRefillAvg()) }}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekViralLoadAvg() }}%</h4>
                                        <h6 class="text-muted m-b-0">Viral load</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="icofont icofont-blood-test f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="viral-ld-area">
                                    <div class="col-9">
                                         <p class=" m-b-0" id="viral-ld-pointer"
                                            data-val="{{performanceDiff( 'viral_load_performance', getWeekViralLoadAvg() )}}">
                                            {{performanceDiff( 'viral_load_performance', getWeekViralLoadAvg() )}}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   {{--  <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekIctAvg() }}%</h4>
                                        <h6 class="text-muted m-b-0">ICT</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="icofont icofont-users-alt-5 f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="ict-area">
                                    <div class="col-9">
                                         <p class=" m-b-0" id="ict-pointer"
                                            data-val="{{performanceDiff( 'ict_performance', getWeekIctAvg() )}}">
                                            {{performanceDiff( 'ict_performance', getWeekIctAvg() )}}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekTptAvg() }}%</h4>
                                        <h6 class="text-muted m-b-0">TPT</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-head-side-cough f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="tpt-area">
                                    <div class="col-9">
                                         <p class=" m-b-0" id="tpt-pointer"
                                            data-val="{{ performanceDiff( 'tpt_performance', getWeekTptAvg() )}}">
                                            {{performanceDiff( 'tpt_performance', getWeekTptAvg() )}}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekTrackingAvg() }}</h4>
                                        <h6 class="text-muted m-b-0">Tracking</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="icofont icofont-ui-contact-list f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="tracking-area">
                                    <div class="col-9">
                                         <p class=" m-b-0" id="tracking-pointer"
                                            data-val="{{performanceDiff( 'tracking_performance', getWeekTrackingAvg() )}}">
                                            {{performanceDiff( 'tracking_performance', getWeekTrackingAvg() )}}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-8">
                                        <h4 class="">{{ getWeekAttAvg() }}%</h4>
                                        <h6 class="text-muted m-b-0">Attendance</h6>
                                    </div>
                                    <div class="col-4 text-right">
                                        <i class="fa fa-hospital-user f-28"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer change-area">
                                <div class="row align-items-center" id="att-area">
                                    <div class="col-9">
                                        <p class=" m-b-0" id="att-pointer"
                                            data-val="{{performanceDiff( 'attendance_performance', getWeekAttAvg() )}}">
                                            {{performanceDiff( 'attendance_performance', getWeekAttAvg() )}}%
                                        </p>
                                    </div>
                                    <div class="col-3 text-right">
                                        <i class="la"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- page statustic card end -->
            </div>

            </div>
            <!-- analysis ends -->
        </div>
        <!-- [ Main Content ] end -->
    </div>
@endsection
@section('jscharting-area')
    <script src="{{asset('assets/js/jscharting/jsc/jscharting.js')}}"></script>
    <script src="{{asset('assets/js/charting.js')}}"></script>
@endsection
<style type="text/css">
    td, .leader-name{
        font-size: 13px !important;
    }
</style>
