<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>



<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Registered Case Managers</h5>
                        <span class="d-block m-t-5">There are a total of <b><code><?php echo e($case_managers->count()); ?></code></b> case manager(s) registered</span>
                        <button type="button" class="btn btn-info btn-sm add-btn" data-toggle="modal" data-target="#add-case-manager-form">
                            <i class="la la-plus-circle"></i> Add Case Manager</button>
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">

                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Case Manager Name</th>
                                        <th>Facility</th>
                                        <th>No. of Clients</th>
                                        <th>Avg Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $case_managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case_mg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="de-<?php echo e($case_mg->id); ?>">
                                        <td><?php echo e($case_mg->id); ?></td>
                                        <td><?php echo e($case_mg->names); ?> <?php echo e($case_mg->surname); ?></td>
                                        <td><?php echo e($case_mg->facility??'None'); ?></td>
                                        <td>
                                            <?php if($case_mg->clients()->count() > 0): ?>
                                                <a href="<?php echo e(route('view_clients_cm', $case_mg->id)); ?>" data-toggle="tooltip"
                                                    title="View clients assigned to <?php echo e($case_mg->name); ?>">
                                                    <?php echo e($case_mg->clients()->count()); ?>

                                                </a>
                                            <?php else: ?>
                                                <?php echo e($case_mg->clients()->count()); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if(cm_performance($case_mg) > 69): ?>
                                                    <span class="badge-pill badge-success">
                                                <?php elseif(cm_performance($case_mg) > 49 && 
                                                        cm_performance($case_mg) < 70): ?>
                                                    <span class="badge-pill badge-info">
                                                <?php elseif(cm_performance($case_mg) < 50): ?>
                                                    <span class="badge-pill badge-danger">
                                            <?php endif; ?>
                                            <?php echo e(cm_performance($case_mg)); ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <button type="button" class="btn btn-info btn-sm" data-toggle="tooltip" title="Edit case manager" onclick="window.location.href='<?php echo e(route('edit-case_mg',$case_mg->id)); ?>'"><i class="la la-edit"></i>
                                                    </button>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#mg<?php echo e($case_mg->id); ?>">
                                                    <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View case manager">
                                                        <i class="la la-eye"></i>
                                                    </button>
                                                </span>
                                                </div>
                                                <div class="col-md-4">
                                                <span data-toggle="modal" data-target="#ts<?php echo e($case_mg->id); ?>">
                                                    <button type="button" class="btn btn-secondary btn-sm" data-toggle="tooltip" data-placement="top" title="View timesheet">
                                                        <i class="la la-calendar-week"></i>
                                                    </button>
                                                </span>
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

            
        <?php $__currentLoopData = $case_managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case_mg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="mg<?php echo e($case_mg->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title cm_view-title" id="exampleModalLabel">
                    
                       
                        <div class="user-details manager-name">
                            <div id="more-details"><?php echo e($case_mg->names); ?></div>
                        </div>
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
                                            <th>Email Address</th>
                                            <td><?php echo e($case_mg->email); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Phone No.</th>
                                            <td><?php echo e($case_mg->phone); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Facility</th>
                                            <td>
                                                <?php if(strlen($case_mg->facility) >= 30): ?>
                                                    <?php echo substr($case_mg->facility,0,20).' <span style="color: #4680ff;">...</span> '.substr($case_mg->facility,-6); ?>

                                                <?php else: ?>
                                                    <?php echo e($case_mg->facility??'None'); ?>

                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>No. of Clients</th>
                                            <td>
                                                <span class="client-count"><?php echo e($case_mg->clients()->count()); ?></span><br/>
                                                <div class="clients-analytica">
                                                    <span class="badge-pill badge-success">Active: <?php echo e(clientsAnalyzer($case_mg->names, 'Active')); ?></span>
                                                    <br/>
                                                    <span class="badge-pill badge-info">Transferred Out: <?php echo e(clientsAnalyzer($case_mg->names, 'Transferred Out')); ?></span><br/>
                                                    <span class="badge-pill badge-secondary">IIT: <?php echo e(clientsAnalyzer($case_mg->names, 'LTFU')); ?></span><br/>
                                                    <span class="badge-pill badge-warning">Stopped: <?php echo e(clientsAnalyzer($case_mg->names, 'Stopped')); ?></span><br/>
                                                    <span class="badge-pill badge-danger">Dead: <?php echo e(clientsAnalyzer($case_mg->names, 'Dead')); ?></span>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Avg. Performance</th>
                                            <td><?php echo e(cm_performance($case_mg)); ?>%</td>
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

        
         <?php $__currentLoopData = $case_managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $case_mg): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="ts<?php echo e($case_mg->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h3 class="modal-title cm_view-title" id="exampleModalLabel">
                    
                       
                        <div class="user-details manager-name">
                            <div id="more-details"><?php echo e($case_mg->names); ?><br>
                                <em style="font-size: 13px">Work Timesheet</em>
                            </div>
                            <button class="btn btn-info la la-cloud-download-alt" onclick="window.location.href='<?php echo e(route('timesheet', $case_mg->id)); ?>'"> Download</button>
                        </div>
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
                                        <?php $__currentLoopData = $case_mg->timesheets(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $time): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <th><?php echo e($time->created_at->format('l jS \of F Y')); ?></th>
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
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
    </div>

    
            <!-- Modal -->
            <div class="modal fade" id="add-case-manager-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Register New Case Manager</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="<?php echo e(route('add-case-manager')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Full Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control<?php echo e($errors->has('name') ? ' is-invalid' : ''); ?>" name="name" value="<?php echo e(old('name')); ?>" placeholder="surname firstname middlename">
                                        <?php if($errors->has('name')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('name')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Email Address</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control<?php echo e($errors->has('email') ? ' is-invalid' : ''); ?>" name="email" value="<?php echo e(old('email')); ?>">
                                        <?php if($errors->has('email')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('email')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>">
                                        <?php if($errors->has('phone')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('phone')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-3 col-form-label">Facility</label>
                                    <div class="col-sm-9">
                                        <select class="form-control<?php echo e($errors->has('facility') ? ' is-invalid' : ''); ?> select-or-search" name="facility" value="<?php echo e(old('facility')); ?>" selected="<?php echo e(old('facility')); ?>" placeholder="Pick a facility">
                                            <option>...</option>
                                            <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($fac->id); ?>"><?php echo e($fac->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                            <?php if($errors->has('facility')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('facility')); ?></strong>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="input-group mb-3 col-sm-12">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Profile Photo</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input<?php echo e($errors->has('profile_photo') ? ' is-invalid' : ''); ?>" id="inputGroupFile01" name="profile_photo" required="">
                                             <?php if($errors->has('profile_photo')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('profile_photo')); ?></strong>
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
                            </form>
                       </div>
                  </div>
                </div>
              </div>
            </div>
            
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/cornel/Documents/Projects/cmams/resources/views/case_manager/index.blade.php ENDPATH**/ ?>