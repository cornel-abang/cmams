<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Registered Clients</h5>
                        <span class="d-block m-t-5">There are a total of <b><code><?php echo e(number_format( cmCount() )); ?></code></b> clients registered</span>
                        
                    </div>
                    <div class="card-body table-border-style">
                        <div class="table-responsive">

                            <table class="table table-striped" id="client-entry-table">
                                <thead>
                                    <tr>
                                        <th>Hospital Number</th>
                                        <th>Facility</th>
                                        <th>Case Manager</th>
                                        
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="de-<?php echo e($client->id); ?>">
                                        <td><?php echo e($client->hospital_num); ?></td>
                                        <td>
                                            <?php echo e($client->facility); ?>

                                        </td>
                                        <td><?php echo e(ucwords(strtolower($client->case_manager))); ?></td>
                                        
                                        <td>
                                            <?php if($client->status === 'Active' || $client->status === 'Active-Restart' || $client->art_status === 'Active-Transfer In'): ?>
                                                <span class="badge-pill badge-success"><?php echo e($client->status); ?></span>
                                            <?php else: ?>
                                                <span class="badge-pill badge-danger"><?php echo e($client->status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <span data-toggle="modal" data-target="#cl<?php echo e($client->id); ?>">
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="View client summary">
                                                        <i class="la la-eye"></i>
                                                </button>
                                            </span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                             <?php echo e($clients->links()); ?>

                        </div>
                    </div>
                </div>
            </div>



            
        <?php $__currentLoopData = $clients; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $client): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="modal fade" id="cl<?php echo e($client->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title" id="exampleModalLabel">
                    <i class="la la-user"></i> <?php echo e($client->name); ?>

                </h4><span class="badge badge-pill badge-info client-status"> <?php echo e($client->art_status); ?></span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <table class="table table-bordered table-striped more-info">
                                        <tr>
                                            <th>Client</th>
                                            <td><?php echo e($client->client_hospital_num); ?></td>
                                        </tr>
                                        <tr>
                                            <th>Next Sample Collection Date: </th>
                                            <td>
                                                <?php if($client->art_status ==='Active' || $client->art_status === 'Active-Transfer' || $client->art_status === 'Active-Restart'): ?>
                                                    <?php echo e(checkApptDate('VL Sample Collection', $client->client_hospital_num, $client->case_manager)); ?>

                                                <?php else: ?>
                                                    Inactive client
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Next Refill Date: </th>
                                            <td>
                                                <?php if($client->art_status ==='Active' || $client->art_status === 'Active-Transfer' || $client->art_status === 'Active-Restart'): ?>
                                                    <?php echo e(checkApptDate('Refill', $client->client_hospital_num, $client->case_manager)); ?>

                                                <?php else: ?>
                                                    Inactive client
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>TPT Status (Last 2yrs): </th>
                                            <td>
                                                <?php if($client->art_status ==='Active' || $client->art_status === 'Active-Transfer' || $client->art_status === 'Active-Restart'): ?>
                                                    <?php if($client->tpt_in_the_last_2_years === 'Yes'): ?>
                                                        <span class=" la la-check-circle" style="color: green;"></span>
                                                    <?php else: ?>
                                                        <span class="la la-times-circle" style="color: red;"></span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    Inactive client
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Case Manager</th>
                                            <td><?php echo e(ucwords(strtolower($client->case_manager))); ?></td>
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
    </div>

    <style type="text/css">
        .more-info td{
            font-size: 12px;
        }

        .more-info td .la{
            font-size: 20px;
            font-weight: bolder;
        }
    </style>



    
            <!-- Modal -->
            <div class="modal fade" id="add-client-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Register New Client</h4>
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
                            <form action="<?php echo e(route('add-client')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="single-upload">
                                <div class="back-arrow"><i class="la la-long-arrow-left"></i></div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Client Name</label>
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
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Client ID</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('clientID') ? ' is-invalid' : ''); ?>" name="clientID" value="<?php echo e(old('clientID')); ?>">
                                            <?php if($errors->has('clientID')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('clientID')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number</label>
                                        <div class="col-sm-9">
                                            <input type="phone" class="form-control<?php echo e($errors->has('phone') ? ' is-invalid' : ''); ?>" name="phone" value="<?php echo e(old('phone')); ?>">
                                            <?php if($errors->has('phone')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('phone')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Phone Number OPC (Optional)</label>
                                        <div class="col-sm-9">
                                            <input type="phone" class="form-control<?php echo e($errors->has('opc_phone') ? ' is-invalid' : ''); ?>" name="opc_phone" value="<?php echo e(old('opc_phone')); ?>">
                                            <?php if($errors->has('opc_phone')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('opc_phone')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Residential Address</label>
                                        <div class="col-sm-9">
                                            <input type="text" class="form-control<?php echo e($errors->has('address') ? ' is-invalid' : ''); ?>" name="address" value="<?php echo e(old('address')); ?>">
                                            <?php if($errors->has('address')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('address')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Status</label>
                                        <div class="col-sm-9">
                                            <select class="form-control<?php echo e($errors->has('status') ? ' is-invalid' : ''); ?> select-or-search" name="status" value="<?php echo e(old('status')); ?>" selected="<?php echo e(old('status')); ?>" placeholder="Pick a status">
                                                <option>...</option>
                                                <option value="Active">Active</option>
                                                <option value="Dead">Dead</option>
                                                <option value="Transferred Out">Transferred Out</option>
                                                <option value="Lost to Follow Up">Lost to Follow Up</option>
                                                <option value="Stop Treatment">Stop Treatment</option>
                                            </select>
                                            <?php if($errors->has('status')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('status')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-3 col-form-label">Facility</label>
                                        <div class="col-sm-9">
                                            <select class="form-control<?php echo e($errors->has('facility') ? ' is-invalid' : ''); ?> select-or-search sel_facility" name="facility" value="<?php echo e(old('facility')); ?>" selected="<?php echo e(old('facility')); ?>" placeholder="Pick a facility">
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
                                    <img src="<?php echo e(asset('assets/images/loading.gif')); ?>" class="loading-img">
                                        <div class="input-group mb-3 col-sm-12">
                                            <div class="input-group-prepend">
                                                <label class="input-group-text" for="inputGroupSelect01">Assign Case Manager</label>
                                            </div>
                                            <select class="custom-select<?php echo e($errors->has('case_manager') ? ' is-invalid' : ''); ?> case_managers_select" name="case_manager" selected="<?php echo e(old('case_manager')); ?>" id="inputGroupSelect01" title="<?php echo e(route('find_case_managers')); ?>" placeholder="Pick a case manager">
                                            </select>
                                            <?php if($errors->has('case_manager')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('case_manager')); ?></strong>
                                                </span>
                                            <?php endif; ?>
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
                                                <input type="file" class="custom-file-input<?php echo e($errors->has('bulk-client') ? ' is-invalid' : ''); ?>" id="inputGroupFile01" name="bulk-client">
                                                 <?php if($errors->has('bulk-client')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('bulk-client')); ?></strong>
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

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/clients/index.blade.php ENDPATH**/ ?>