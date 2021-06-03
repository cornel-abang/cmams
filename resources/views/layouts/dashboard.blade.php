<!DOCTYPE html>
<html lang="en">

<head>
    <title>QMAMS - {{ !empty($title) ? $title : __('app.dashboard') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta content="{{ csrf_token() }}" id="csrf_area">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="{{asset('assets/images/favicon.png')}}" type="image/x-icon">

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <!-- vendor css -->
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/datatables.css')}}">
    <link rel="stylesheet" href="{{asset('assets/js/selectize.js-master/dist/css/selectize.bootstrap3.css')}}"/>

    {{-- Fonts --}}
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/icofont.css')}}">
    <link href="{{ asset('assets/line-awesome/css/line-awesome.min.css')}}" rel="stylesheet">
    <link href="{{ asset('assets/font-awesome-5/css/all.min.css')}}" rel="stylesheet">
    <script type='text/javascript'>
        var page_data = {!! pageJsonData() !!};
    </script>
   @yield('sweet-alert-area')
</head>
<body class="">
	<!-- [ Pre-loader ] start -->
	<div class="loader-bg">
		<div class="loader-track">
			<div class="loader-fill"></div>
		</div>
	</div>
	<!-- [ Pre-loader ] End -->
	<!-- [ navigation menu ] start -->
	<nav class="pcoded-navbar menu-light ">
		<div class="navbar-wrapper  ">
			<div class="navbar-content scroll-div " >

				{{-- <div class="">
					<div class="main-menu-header">
						<img class="img-radius" src="{{asset('assets/images/logo.png')}}" alt="cmams-logo">
						<div class="user-details">
							<div id="more-details">FHI360 - CMAMS </div>
						</div>
					</div>
				</div> --}}

				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
					    <label>Navigation</label>
					</li>

					<li class="nav-item">
					    <a href="{{route('dashboard')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-chart-line"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>

					<li class="nav-item">
					    <a href="{{route('facilities')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-hospital"></i></span><span class="pcoded-mtext">Facilities</span></a>
					</li>

					<li class="nav-item">
					    <a href="{{route('case-managers')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-users-alt-3"></i></span><span class="pcoded-mtext">Case Managers</span></a>
					</li>
					<li class="nav-item">
					    <a href="{{route('clients')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-users-social"></i></span><span class="pcoded-mtext">Clients</span></a>
					</li>
					<li class="nav-item">
					    <a href="{{route('upload.radet')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">Radet Import</span></a>
					</li>

					{{-- <li class="nav-item">
					    <a href="{{route('vlc')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">VLC Turnaround</span></a>
					</li> --}}

					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">Reports</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="{{route('daily')}}">Daily Report</a></li>
					        {{-- <li>
							  <a href="#!" class="nav-link  down-icon"><span class="pcoded-micon"><i class="icofont icofont-ui-contact-list"></i></span>
							  	<span class="pcoded-mtext">Tracking Records</span></a>
							    <ul class="pcoded-submenu">
							        <li><a href="{{route('add')}}">Add</a></li>
							        <li><a href="{{route('tracking_reports')}}">View all</a></li>
							    </ul>
					        </li> --}}
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">TAT Tracker</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="{{route('tat.compare')}}">Compare Results</a></li>
					        {{-- <li>
							  <a href="#!" class="nav-link  down-icon"><span class="pcoded-micon"><i class="icofont icofont-ui-contact-list"></i></span>
							  	<span class="pcoded-mtext">Tracking Records</span></a>
							    <ul class="pcoded-submenu">
							        <li><a href="{{route('add')}}">Add</a></li>
							        <li><a href="{{route('tracking_reports')}}">View all</a></li>
							    </ul>
					        </li> --}}
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-calendar"></i></span>
					    	<span class="pcoded-mtext">Appointments</span></a>
					    <ul class="pcoded-submenu">
					        {{-- <li><a href="{{route('add-appts')}}">Add</a></li> --}}
					        <li><a href="{{route('appointments')}}">View all </a></li>
					        <li><a href="{{route('met')}}">Met </a></li>
					        <li><a href="{{ route('before') }}">Pre-appointment Refills <strong>Past</strong></a></li>
					        <li><a href="{{ route('before_future') }}">Pre-appointment Refills <strong>Future</strong></a></li>
					        <li><a href="{{route('missed')}}">Missed </a></li>
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-hospital-user"></i></span>
					    	<span class="pcoded-mtext">Attendance</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="{{route('atts')}}">This Month</a></li>
					        <li><a href="{{route('permitted')}}">Permitted List </a></li>
					    </ul>
					</li>
					{{-- <li class="nav-item">
					    <a href="{{route('atts')}}" class="nav-link "><span class="pcoded-micon">
					    	<i class="fa fa-hospital-user"></i></span><span class="pcoded-mtext">Attendance</span></a>
					</li> --}}
				</ul>
			</div>
		</div>
	</nav>
	<!-- [ navigation menu ] end -->
	<!-- [ Header ] start -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">
				<div class="m-header">
					<a class="mobile-menu" id="mobile-collapse" href="#!"><span></span></a>
					<a href="#!" class="b-brand">
						<!-- ========   change your logo hear   ============ -->
						<img src="{{asset('assets/images/logo.png')}}" alt="" class="logo">
						<img src="{{asset('assets/images/logo-icon.png')}}" alt="" class="logo-thumb">
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
					{{-- <ul class="navbar-nav mr-auto">
						<li class="nav-item">
							<a href="#!" class="pop-search"><i class="feather icon-search"></i></a>
							<div class="search-bar">
								<input type="text" class="form-control border-0 shadow-none" placeholder="Search hear">
								<button type="button" class="close" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
						</li>
					</ul> --}}
					<ul class="navbar-nav ml-auto">
						<li class="logout-area">
							<div class="dropdown drp-user">
								<a href="{{route('logout')}}" class="" data-toggle="tooltip" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
						</li>
					</ul>
				</div>
	</header>
	<!-- [ Header ] end -->
	<div class="col-md-6 session-messages">
        @include('admin.flash_msg')
    </div>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
	{{-- Ajax Call Screen Wait Area --}}
   <div class="load-screen"></div>
	@yield('content')
</div>
<!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="{{asset('assets/js/vendor-all.min.js')}}"></script>
    <script src="{{asset('assets/js/plugins/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/ripple.js')}}"></script>
    <script src="{{asset('assets/js/pcoded.min.js')}}"></script>
    {{-- Custom Js file --}}
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="{{asset('assets/js/freeze.js')}}"></script>

    {{-- Datatbales --}}
    {{-- <link rel="stylesheet" href="{{asset('assets/DataTable/datatables.min.css') }}">
    <script src="{{asset('assets/DataTable/datatables.min.js') }}" defer></script> --}}
    <script src="{{asset('assets/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('assets/js/datatable/datatables/datatable.custom.js')}}"></script>
    <script src="{{asset('assets/js/selectize.js-master/dist/js/standalone/selectize.min.js')}}"></script>

	{{-- jscharting --}}
	 @yield('jscharting-area')

	@yield('page-js')
	</body>

</html>
