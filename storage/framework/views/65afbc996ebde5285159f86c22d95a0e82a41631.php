
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>List of permitted case managers</h5>
                        <span class="d-block m-t-5">A total of <b><code><?php echo e($p_lists->count()); ?></code></b> case managers have been granted attendance permission today.</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-facility-form">
                            <i class="la la-plus-circle"></i> Add List</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>Case Manager</th>
                                        <th>Facility</th>
                                        <th>Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $p_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($list->case_manager); ?></td>
                                        <td><?php echo e($list->facility); ?></td>
                                        <td><?php echo e($list->reason); ?></td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit facility" onclick="window.location.href='<?php echo e(route('edit-facility')); ?>'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#list<?php echo e($list->id); ?>">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View facility">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="" class="btn btn-danger btn-sm delete-btn-facility" data-toggle="tooltip" title="Delete facility"><i class="la la-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

            
        <?php $__currentLoopData = $p_lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="list<?php echo e($list->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title view-title" id="exampleModalLabel">
                    <i class="la la-user"></i> <?php echo e($list->case_manager); ?>

                </h3>
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
                                            <th>Approved By:</th>
                                            <td><?php echo e($list->approved_by); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Reason:</th>
                                            <td><?php echo e($list->reason); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Date:</th>
                                            <td><?php echo e(Carbon\Carbon::parse($list->permit_date)->format('l jS \of F Y')); ?></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
            <!-- Modal -->
            <div class="modal fade" id="add-facility-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h3 class="modal-title view-title" id="exampleModalLabel">Add aprroved list</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <div class="col-md-12 options">
                                <div class="single-tab"><i class="la la-file-o"> Single Case Manager</i></div>
                                <div class="bulk-tab"><i class="la la-files-o"></i> Bulk Upload</div>
                            </div>
                            <form action="<?php echo e(route('add-facility')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="single-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Case Manager:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('case_manager') ? ' is-invalid' : ''); ?>" name="case_manager" value="<?php echo e(old('case_manager')); ?>">
                                            <?php if($errors->has('case_manager')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('case_manager')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Approved By:</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('approved_by') ? ' is-invalid' : ''); ?>" name="approved_by" value="<?php echo e(old('approved_by')); ?>">
                                            <?php if($errors->has('approved_by')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('approved_by')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="bulk-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                        <div class="input-group mb-3 col-sm-12">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text">Upload CSV</label>
                                            </div>
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input<?php echo e($errors->has('bulk-facility') ? ' is-invalid' : ''); ?>" id="inputGroupFile01" name="bulk-facility">
                                                 <?php if($errors->has('bulk-facility')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('bulk-facility')); ?></strong>
                                                </span>
                                                <?php endif; ?>
                                                <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-10">
                                                <button type="submit" class="btn  btn-primary reg-btn">Add</button>
                                            </div>
                                        </div>
                                </div>
                            </form>
                       </div>         
                  </div>
                </div>
              </div>
            </div>
            
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/case_manager/permitted.blade.php ENDPATH**/ ?>