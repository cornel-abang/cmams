
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>

<!-- [ stiped-table ] start -->
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>UCTH TAT Records</h5>
                        <span class="d-block m-t-5">There are a total of <b><code><?php echo e($tats->count()); ?></code></b> TAT records for UCTH</span>
                        
                    <div class="card-body table-border-style">
                        <div class="table-responsive">
                           
                            <table class="table table-striped" id="entry-table">
                                <thead>
                                    <tr>
                                        
                                        <th>Patient Name</th>
                                        <th>Lab No.</th>
                                        <th>Hospital No.</th>
                                        <th>Sex</th>
                                        <th>Age</th>
                                        <th>Test Requested</th>
                                        <th>EID Results (Neg/Pos)</th>
                                        <th>V/L Result (Copies/ml)</th>
                                        <th>Gene Xpert (Neg/Pos)</th>
                                        <th>CD4 Result (cells/µl)</th>
                                        <th>Date Test Requested</th>
                                        <th>TAT 1 in Days</th>
                                        <th>Date Sample Collected</th>
                                        <th>Time Sample Collected</th>
                                        <th>TAT 2 in Days</th>
                                        <th>Sample Pick up Date</th>
                                        <th>Sample Transported/Picked up By</th>
                                        <th>Date Sample Recieved at Lab</th>
                                        <th>TAT 3 in Days</th>
                                        <th>Name of Recieving/Testing Laboratory</th>
                                        <th>Date Samples Tested/Assay Date</th>
                                        <th>TAT 4 in Days</th>
                                        <th>Date Result Released to Facility</th>
                                        <th>TAT 5 in Days</th>
                                        <th>Date Result Recieved at Clinic</th>
                                        <th>TAT 6 in Days</th>
                                        <th>Date Result Entered into Medical record</th>
                                        <th>TAT 7 in Days</th>
                                        <th>Date Patient Notified Result is Ready</th>
                                        <th>TAT 8 in Days</th>
                                        <th>Date Result Given to Patient</th>
                                        <th>Overall TAT in Days</th>
                                        <th>Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        
                                        <td><?php echo e($tat->patient_name); ?></td>
                                        <td><?php echo e($tat->lab_no); ?></td>
                                        <td><?php echo e($tat->hospital_no); ?></td>
                                        <td><?php echo e($tat->sex); ?></td>
                                        <td><?php echo e($tat->age); ?></td>
                                        <td>
                                            <select type="text" name="test_type" value="<?php echo e($tat->test_type); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                                <option value="VL" <?php echo e($tat->test_type==='VL'?'selected':''); ?>>VL</option>
                                                <option value="EID" <?php echo e($tat->test_type==='EID'?'selected':''); ?>>EID</option>
                                                <option value="CD4" <?php echo e($tat->test_type==='CD4'?'selected':''); ?>>CD4</option>
                                                <option value="Gene Xpert" <?php echo e($tat->test_type==='Gene Xpert'?'selected':''); ?>>Gene Xpert</option>
                                        </td>
                                        <td>
                                            <input type="text" name="eid_res" value="<?php echo e($tat->eid_res); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="vl_res" value="<?php echo e($tat->vl_res); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="gene_xpert_res" value="<?php echo e($tat->gene_xpert_res); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="cd_4_res" value="<?php echo e($tat->cd_4_res); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_test_requested" value="<?php echo e($tat->date_test_requested); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_test_requested)->format('l jS \of F Y')); ?>">
                                            
                                        </td>
                                        <td>
                                            <input type="number" name="tat_1" value="<?php echo e($tat->tat_1); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_sample_collected" value="<?php echo e($tat->date_sample_collected); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_sample_collected)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="time_sample_collected" value="<?php echo e($tat->time_sample_collected); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_2" value="<?php echo e($tat->tat_2); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="sample_pickup_date" value="<?php echo e($tat->sample_pickup_date); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->sample_pickup_date)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="sample_trans_pick_by" value="<?php echo e($tat->sample_trans_pick_by); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_sample_rec_at_lab" value="<?php echo e($tat->date_sample_rec_at_lab); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_sample_rec_at_lab)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_3" value="<?php echo e($tat->tat_3); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="name_of_rec_testing_lab" value="<?php echo e($tat->name_of_rec_testing_lab); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_samples_tested_assay_test" value="<?php echo e($tat->date_samples_tested_assay_test); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_samples_tested_assay_test)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_4" value="<?php echo e($tat->tat_4); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_released_to_facility" value="<?php echo e($tat->date_res_released_to_facility); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_res_released_to_facility)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_5" value="<?php echo e($tat->tat_5); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_reci_at_clinic" value="<?php echo e($tat->date_res_reci_at_clinic); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_res_reci_at_clinic)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_6" value="<?php echo e($tat->tat_6); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_entered_into_med_record" value="<?php echo e($tat->date_res_entered_into_med_record); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_res_entered_into_med_record)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_7" value="<?php echo e($tat->tat_7); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_patient_notified_res_ready" value="<?php echo e($tat->date_patient_notified_res_ready); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_patient_notified_res_ready)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="tat_8" value="<?php echo e($tat->tat_8); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="date" name="date_res_given_to_patient" value="<?php echo e($tat->date_res_given_to_patient); ?>" class="record" data-id="<?php echo e($tat->id); ?>" data-toggle="tooltip" title="<?php echo e(\Carbon\Carbon::parse($tat->date_res_given_to_patient)->format('l jS \of F Y')); ?>">
                                        </td>
                                        <td>
                                            <input type="number" name="overall_tat" value="<?php echo e($tat->overall_tat); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                        <td>
                                            <input type="text" name="remarks" value="<?php echo e($tat->remarks); ?>" class="record" data-id="<?php echo e($tat->id); ?>">
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            
                        </div>
                    </div>
                </div>
            </div>

            
       

    
            <!-- Modal -->
            <div class="modal fade" id="add-record-form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">Add new TAT record</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div class="row">
                       <div class="col-md-12">
                            <form action="<?php echo e(route('tat.single')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="">
                                
                                  
                                    <div class="form-group row">
                                        
                                        <div class="col-sm-12">
                                            <select class="form-control<?php echo e($errors->has('status') ? ' is-invalid' : ''); ?> select-or-search" name="client" placeholder="Search Client Name">
                                                <option value="">Search Client Name</option>
                                                <?php $__currentLoopData = $ps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($p->id); ?>"><?php echo e($p->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php if($errors->has('client')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('client')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        
                                        <div class="col-sm-12">
                                            <select class="form-control<?php echo e($errors->has('status') ? ' is-invalid' : ''); ?> select-or-search" name="test_type" placeholder="Test type">
                                                <option value="">Test requested</option>
                                                <option value="EID">EID</option>
                                                <option value="VL">VL</option>
                                                <option value="CD4">CD4</option>
                                                <option value="Gene Xpert">Gene Xpert</option>
                                            </select>
                                            <?php if($errors->has('client')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('client')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control<?php echo e($errors->has('lab_no') ? ' is-invalid' : ''); ?>" name="lab_no" value="<?php echo e(old('phone')); ?>" placeholder="Lab No">
                                            <?php if($errors->has('phone')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('phone')); ?></strong>
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputEmail3" class="col-sm-4 col-form-label">Test Request Date</label>
                                        <div class="col-sm-8">
                                            <input type="date" class="form-control<?php echo e($errors->has('date_test_requested') ? ' is-invalid' : ''); ?>" name="date_test_requested" value="<?php echo e(old('date_test_requested')); ?>">
                                            <?php if($errors->has('date_test_requested')): ?>
                                                <span class="invalid-feedback" role="alert">
                                                    <strong><?php echo e($errors->first('date_test_requested')); ?></strong>
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
                            </form>
                       </div>
                  </div>
                </div>
              </div>
            </div>
            

            <style type="text/css">
                .hide-rec{
                    display: none;
                }

                .record{
                    border: 0;
                    background-color: inherit;
                }

                select.record{
                    width: 50px;
                    background-color: inherit;
                }

                input[type="date"].record{
                    width: 125px;
                    background-color: inherit;
                }

                .table.dataTable[class*="table-"] thead th{
                    background-color: #4680ff !important;
                    color: white;
                    font-size: 16px;
                    font-weight: bold;
                }
            </style>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/tat/index.blade.php ENDPATH**/ ?>