<!DOCTYPE html>
<html lang="en">

<head>
    <title>QMAMS - <?php echo e(!empty($title) ? $title : __('app.dashboard')); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">
    <meta content="<?php echo e(csrf_token()); ?>" id="csrf_area">
    <meta name="author" content="Phoenixcoded" />
    <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/datatables.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/js/selectize.js-master/dist/css/selectize.bootstrap3.css')); ?>"/>

    
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/icofont.css')); ?>">
    <link href="<?php echo e(asset('assets/line-awesome/css/line-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/font-awesome-5/css/all.min.css')); ?>" rel="stylesheet">
    <script type='text/javascript'>
        var page_data = <?php echo pageJsonData(); ?>;
    </script>
   <?php echo $__env->yieldContent('sweet-alert-area'); ?>
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

				

				<ul class="nav pcoded-inner-navbar ">
					<li class="nav-item pcoded-menu-caption">
					    <label>Navigation</label>
					</li>

					<li class="nav-item">
					    <a href="<?php echo e(route('dashboard')); ?>" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-chart-line"></i></span><span class="pcoded-mtext">Dashboard</span></a>
					</li>

					<li class="nav-item">
					    <a href="<?php echo e(route('facilities')); ?>" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-hospital"></i></span><span class="pcoded-mtext">Facilities</span></a>
					</li>

					<li class="nav-item">
					    <a href="<?php echo e(route('case-managers')); ?>" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-users-alt-3"></i></span><span class="pcoded-mtext">Case Managers</span></a>
					</li>
					<li class="nav-item">
					    <a href="<?php echo e(route('clients')); ?>" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-users-social"></i></span><span class="pcoded-mtext">Clients</span></a>
					</li>
					<li class="nav-item">
					    <a href="<?php echo e(route('upload.radet')); ?>" class="nav-link "><span class="pcoded-micon">
					    	<i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">Radet Import</span></a>
					</li>

					

					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">Reports</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="<?php echo e(route('daily')); ?>">Daily Report</a></li>
					        
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-file-alt"></i></span><span class="pcoded-mtext">TAT Tracker</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="<?php echo e(route('tat.compare')); ?>">Compare Results</a></li>
					        
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="icofont icofont-calendar"></i></span>
					    	<span class="pcoded-mtext">Appointments</span></a>
					    <ul class="pcoded-submenu">
					        
					        <li><a href="<?php echo e(route('appointments')); ?>">View all </a></li>
					        <li><a href="<?php echo e(route('met')); ?>">Met </a></li>
					        <li><a href="<?php echo e(route('before')); ?>">Pre-appointment Refills <strong>Past</strong></a></li>
					        <li><a href="<?php echo e(route('before_future')); ?>">Pre-appointment Refills <strong>Future</strong></a></li>
					        <li><a href="<?php echo e(route('missed')); ?>">Missed </a></li>
					    </ul>
					</li>
					<li class="nav-item pcoded-hasmenu">
					    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="fa fa-hospital-user"></i></span>
					    	<span class="pcoded-mtext">Attendance</span></a>
					    <ul class="pcoded-submenu">
					        <li><a href="<?php echo e(route('atts')); ?>">This Month</a></li>
					        <li><a href="<?php echo e(route('permitted')); ?>">Permitted List </a></li>
					    </ul>
					</li>
					
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
						<img src="<?php echo e(asset('assets/images/logo.png')); ?>" alt="" class="logo">
						<img src="<?php echo e(asset('assets/images/logo-icon.png')); ?>" alt="" class="logo-thumb">
					</a>
					<a href="#!" class="mob-toggler">
						<i class="feather icon-more-vertical"></i>
					</a>
				</div>
				<div class="collapse navbar-collapse">
					
					<ul class="navbar-nav ml-auto">
						<li class="logout-area">
							<div class="dropdown drp-user">
								<a href="<?php echo e(route('logout')); ?>" class="" data-toggle="tooltip" title="Logout">
									<i class="feather icon-log-out"></i>
								</a>
							</div>
						</li>
					</ul>
				</div>
	</header>
	<!-- [ Header ] end -->
	<div class="col-md-6 session-messages">
        <?php echo $__env->make('admin.flash_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
	
   <div class="load-screen"></div>
	<?php echo $__env->yieldContent('content'); ?>
</div>
<!-- [ Main Content ] end -->

    <!-- Required Js -->
    <script src="<?php echo e(asset('assets/js/vendor-all.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/plugins/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/ripple.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/pcoded.min.js')); ?>"></script>
    
    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/freeze.js')); ?>"></script>

    
    
    <script src="<?php echo e(asset('assets/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datatable/datatables/datatable.custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/selectize.js-master/dist/js/standalone/selectize.min.js')); ?>"></script>

	
	 <?php echo $__env->yieldContent('jscharting-area'); ?>

	<?php echo $__env->yieldContent('page-js'); ?>
	</body>

</html>
<?php /**PATH /Users/cornel/Documents/Projects/cmams/resources/views/layouts/dashboard.blade.php ENDPATH**/ ?>