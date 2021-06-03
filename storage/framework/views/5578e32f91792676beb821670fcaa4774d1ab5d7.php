<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

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
                                <p class="card-text"><h3 class="card-title"><?php echo e($facilities->count()); ?></h3></p>
                                <a href="<?php echo e(route('facilities')); ?>" class="btn  btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-12 col-md-4">
                        <hr>
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title">Case Managers</h3>
                                <p class="card-text"><h3 class="card-title"><?php echo e($case_managers->count()); ?></h3></p>
                                <a href="<?php echo e(route('case-managers')); ?>" class="btn  btn-primary">See all</a>
                            </div>
                        </div>
                    </div>
                     <div class="col-sm-12 col-md-4">
                        <hr>
                        <div class="card text-center">
                            <div class="card-body">
                                <h3 class="card-title">Clients</h3>
                                <p class="card-text"><h3 class="card-title"><?php echo e(number_format(cmCount())); ?></h3></p>
                                <a href="<?php echo e(route('clients')); ?>" class="btn  btn-primary">See all</a>
                                
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
                        <h5>This week's case managers' leaderboard <span id="set">(Top Performers)</span></h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item"><a href="<?php echo e(route('leaderboard')); ?>"><span><i class="feather icon-maximize"></i> See all</span></li>
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
                                        
                                        <th class="text-right">Score (%)</th>
                                    </tr>
                                </thead>
                                <tbody id="top4">
                                    <?php $__currentLoopData = $top4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perfs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                        
                                                        <div class="d-inline-block">
                                                            <h6 class="leader-name"><?php echo e($perfs['name']); ?></h6>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-right">
                                                    <?php if( $perfs['performance'] > 69 ): ?>
                                                        <label class="badge-pill badge-success"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php elseif( $perfs['performance'] > 49 && $perfs['performance'] < 70 ): ?>
                                                        <label class="badge-pill badge-primary"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php elseif( $perfs['performance'] < 50): ?>
                                                        <label class="badge-pill badge-danger"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php endif; ?>
                                            </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <div class="" id="load"></div>
                                </tbody>
                                <tbody id="bottom4" class="shut">
                                    <?php $__currentLoopData = $bottom4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $perfs): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td>
                                                    <div class="d-inline-block align-middle">
                                                       
                                                        <div class="d-inline-block">
                                                            <h6 class="leader-name"><?php echo e($perfs['name']); ?></h6>
                                                            
                                                        </div>
                                                    </div>
                                                </td>
                                                
                                                <td class="text-right">
                                                    <?php if( $perfs['performance'] > 69 ): ?>
                                                        <label class="badge-pill badge-success"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php elseif( $perfs['performance'] > 49 && $perfs['performance'] < 70 ): ?>
                                                        <label class="badge-pill badge-primary"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php elseif( $perfs['performance'] < 50): ?>
                                                        <label class="badge-pill badge-danger"><?php echo e($perfs['performance']); ?></label></td>
                                                    <?php endif; ?>
                                            </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="">
                            
                            <div class="row p-t-30 p-b-30">
                               
                                <span class="week-period" data-lw="<?php echo e($startOfLastWeek = \Carbon\Carbon::now()->subDays(7)->startOfWeek()); ?>">
                                            Between<br> Last Week (<?php echo e($startOfLastWeek->format('l jS \of F Y')); ?> - <?php echo e($startOfLastWeek->endOfWeek()->format('l jS \of F Y')); ?>) & This Week (<?php echo e(\Carbon\Carbon::now()->startOfWeek()->format('l jS \of F Y')); ?> - Till Date)
                                </span>
                            </div>
                            
                        </div>
                        
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
                                        <h4 class=""><?php echo e(getWeekRefillAvg()); ?>%</h4>
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
                                            data-val="<?php echo e(performanceDiff( 'refill_performance', getWeekRefillAvg())); ?>">
                                            <?php echo e(performanceDiff( 'refill_performance', getWeekRefillAvg())); ?>%
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
                                        <h4 class=""><?php echo e(getWeekViralLoadAvg()); ?>%</h4>
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
                                            data-val="<?php echo e(performanceDiff( 'viral_load_performance', getWeekViralLoadAvg() )); ?>">
                                            <?php echo e(performanceDiff( 'viral_load_performance', getWeekViralLoadAvg() )); ?>%
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
                                        <h4 class=""><?php echo e(getWeekTptAvg()); ?>%</h4>
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
                                            data-val="<?php echo e(performanceDiff( 'tpt_performance', getWeekTptAvg() )); ?>">
                                            <?php echo e(performanceDiff( 'tpt_performance', getWeekTptAvg() )); ?>%
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
                                        <h4 class=""><?php echo e(getWeekAttAvg()); ?>%</h4>
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
                                            data-val="<?php echo e(performanceDiff( 'attendance_performance', getWeekAttAvg() )); ?>">
                                            <?php echo e(performanceDiff( 'attendance_performance', getWeekAttAvg() )); ?>%
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
<?php $__env->stopSection(); ?>
<?php $__env->startSection('jscharting-area'); ?>
    <script src="<?php echo e(asset('assets/js/jscharting/jsc/jscharting.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/charting.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<style type="text/css">
    td, .leader-name{
        font-size: 13px !important;
    }
</style>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/admin/index.blade.php ENDPATH**/ ?>