
<?php $__env->startSection('content'); ?>


<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5><?php echo e($title); ?></h5>
                        <span class="d-block m-t-5">
                            A total of <b><code><?php echo e($befores->count()); ?></code></b> clients have come in before due date so far.
                        </span>
                        <button type="button" class="btn btn-info btn-sm add-btn">
                            <a href="<?php echo e(route('export-future')); ?>" style="color: white; font-weight: bold;">
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
                                    <?php $__currentLoopData = $befores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($appt->client); ?></td>
                                        <td><?php echo e($appt->case_manager); ?></td>
                                        <td><?php echo e(Carbon\Carbon::parse($appt->due_date)->format('l jS \of F Y')); ?></td>
                                        <td><?php echo e(Carbon\Carbon::parse($appt->returned_date)->format('l jS \of F Y')); ?></td>
                                        <td><?php echo e($appt->facility); ?></td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/appts/before_due_future.blade.php ENDPATH**/ ?>