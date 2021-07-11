<!DOCTYPE html>
<html>
<head>
	<title><?php echo e($title??'Case Manager timesheet'); ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	 <!-- Favicon icon -->
    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">

    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    
    <!-- vendor css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">

    <link rel='stylesheet' href='<?php echo e(public_path('assets/css/plugins/bootstrap.min.css')); ?>' type='text/css' media='all' />
    
    <link href="<?php echo e(asset('assets/line-awesome/css/line-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('assets/font-awesome-5/css/all.min.css')); ?>" rel="stylesheet">
</head>
<body style="background-color: white !important">
    <div class="coat-arms" style="margin-left: 35%;">
        <img src="<?php echo e(public_path('assets/images/coat.jpg')); ?>" height="150" width="200">
    </div>
    <div style="text-align: center; background-color: white !important; margin-top: 20px;">
            <h5>Case Manager Work Timesheet: <?php echo e($names); ?></h5>
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
                                            <?php $__currentLoopData = $atts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($time->created_at->format('l jS \of F Y')); ?></td>
                                                    <td>
                                                        <?php if(\Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime) > 0): ?>
                                                            <span>
                                                                <?php echo e(\Carbon\Carbon::parse($time->checkoutTime)->diffInHours($time->checkInTime)); ?> Hour(s)
                                                            </span>
                                                            <?php else: ?>
                                                            <span>
                                                                <?php echo e(gmdate('H:i:s', \Carbon\Carbon::parse($time->checkoutTime)->diffInSeconds($time->checkInTime))); ?> - 0 Hours
                                                            </span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        29230
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <tfoot>
                                                <tr><th style="font-size: 17px; font-weight: bold;"><?php echo e($time->created_at->format('F Y')); ?></th></tr>
                                            </tfoot>
                                        </tbody>
                                           
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
<script src="<?php echo e(public_path('assets/js/plugins/bootstrap.min.js')); ?>"></script>
</body>
</html><?php /**PATH C:\laragon\www\qmams\resources\views/case_manager/timesheets.blade.php ENDPATH**/ ?>