
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Registered Facilities</h5>
                        <span class="d-block m-t-5">There are a total of <b><code><?php echo e(facilityCount()); ?></code></b> facilities registered</span>
                        
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-facility-form">
                            <i class="la la-plus-circle"></i> Add Facility</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Facility Name</th>
                                        <th>Backstop</th>
                                        <th>No. of Case Managers</th>
                                        <th>No. of Clients</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="de-<?php echo e($facility->id); ?>">
                                        <td><?php echo e($facility->id); ?></td>
                                        <td><?php echo e($facility->name); ?></td>
                                        <td><?php echo e($facility->backstop); ?></td>
                                        <td>
                                            <?php if($facility->caseManagers()->count() > 0): ?>
                                                <a href="<?php echo e(route('view_case_managers',$facility->id)); ?>" data-toggle="tooltip" 
                                                    title="View case managers in <?php echo e($facility->name); ?>">
                                                    <?php echo e($facility->caseManagers()->count()); ?>

                                                </a>
                                            <?php else: ?>
                                                <?php echo e($facility->caseManagers()->count()); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($facility->clients()->count() > 0): ?>
                                                <a href="<?php echo e(route('view_clients', $facility->id)); ?>" data-toggle="tooltip" 
                                                    title="View clients in <?php echo e($facility->name); ?>">
                                                    <?php echo e($facility->clients()->count()); ?>

                                                </a>
                                            <?php else: ?>
                                                <?php echo e($facility->clients()->count()); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit facility" onclick="window.location.href='<?php echo e(route('edit-facility',$facility->id)); ?>'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#fac<?php echo e($facility->id); ?>">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View facility">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                    <button type="button" id="<?php echo e($facility->id); ?>" class="btn btn-danger btn-sm delete-btn-facility" data-toggle="tooltip" title="Delete facility"><i class="la la-trash"></i>
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

            
        <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="fac<?php echo e($facility->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title view-title" id="exampleModalLabel">
                    <i class="la la-hospital"></i> <?php echo e($facility->name); ?>

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
                                            <th>Name of Backstop</th>
                                            <td><?php echo e($facility->backstop); ?></td>
                                        </tr>
                                        <tr>
                                            <th>No. of Case Managers</th>
                                            <td><?php echo e($facility->caseManagers()->count()); ?></td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td><?php echo e($facility->clients()->count()); ?></td>
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
                    <h3 class="modal-title view-title" id="exampleModalLabel">Register New Facility</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <div class="col-md-12 options">
                                <div class="single-tab"><i class="la la-file-o"> Single Facilty</i></div>
                                <div class="bulk-tab"><i class="la la-files-o"></i> Bulk Upload</div>
                            </div>
                            <form action="<?php echo e(route('add-facility')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="single-upload">
                                    <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Facilty Name</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>">
                                            <?php if($errors->has('name')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('name')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-3 col-form-label">Name of Backstop</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('backstop') ? ' is-invalid' : ''); ?>" name="backstop" value="<?php echo e(old('backstop')); ?>">
                                            <?php if($errors->has('name')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('backstop')); ?></strong>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/facility/index.blade.php ENDPATH**/ ?>