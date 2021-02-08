<!DOCTYPE html>
<html>
<head>
	<title>{{ $title??'Case Manager timesheet' }}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	 <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">

    <link rel='stylesheet' href='{{ public_path('assets/css/plugins/bootstrap.min.css') }}' type='text/css' media='all' />
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}"> --}}
    <link href="{{ asset('assets/line-awesome/css/line-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome-5/css/all.min.css')}}" rel="stylesheet">
</head>
<body style="background-color: white !important">
    <div class="coat-arms" style="margin-left: 35%;">
        <img src="{{ public_path('assets/images/coat.jpg') }}" height="150" width="200">
    </div>
    <div style="text-align: center; background-color: white !important; margin-top: 20px;">
            <h5>Case Manager Work Timesheet: {{ $names }}</h5>
        </div>
    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Hours Worked</th>
                                                <th>FCO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($atts as $time)
                                                <tr>
                                                    <td>{{ $time->created_at->format('l jS \of F Y') }}</td>
                                                    <td>
                                                        @if(\Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) > 0)
                                                            <span>
                                                                {{ \Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) }} Hour(s)
                                                            </span>
                                                            @else
                                                            <span>
                                                                {{ gmdate('H:i:s', \Carbon\Carbon::parse($time->checkoutTime)->diffInSeconds($time->checkInTime)) }} - 0 Hours
                                                            </span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        29230
                                                    </td>
                                                </tr>
                                            @endforeach
                                            <tfoot>
                                                <tr><th style="font-size: 17px; font-weight: bold;">{{ $time->created_at->format('F Y') }}</th></tr>
                                            </tfoot>
                                        </tbody>
                                           {{--  <tr>
                                                <th>{{ $time->created_at->format('l jS \of F Y') }}</th>
                                                <td>
                                                    @if(\Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) > 0)
                                                        <span>
                                                            {{ \Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) }} Hour(s)
                                                        </span>
                                                        @else
                                                        <span>
                                                            {{ gmdate('H:i:s', \Carbon\Carbon::parse($time->checkoutTime)->diffInSeconds($time->checkInTime)) }} - 0 Hours
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr> --}}
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
<style type="text/css">
    .coat-arms{
        display: flex !important; 
        justify-content: center !important; 
        align-items: center !important;
    }
</style>
<script src="{{public_path('assets/js/plugins/bootstrap.min.js')}}"></script>
</body>
</html>