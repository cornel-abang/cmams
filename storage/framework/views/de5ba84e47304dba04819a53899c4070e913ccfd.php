
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>
                    <div class="row">
                       <div class="col-md-6 edit-form">
                            <h3 class="mt-5 edit-title">Upload Result Copy <br><span class="styled-header">Files</span> </h3>
                            <hr>
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="input-group mb-3 col-sm-12 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Hard Copy</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input<?php echo e($errors->has('hard') ? ' is-invalid' : ''); ?> inFld" id="inputGroupFile01" name="hard">
                                             <?php if($errors->has('hard')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('hard')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                    <small class="val" id="val-evidence">Allowed Format: xlsx, csv, txt</small>
                                </div>
                                <div class="input-group mb-3 col-sm-12 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Soft Copy</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input<?php echo e($errors->has('soft') ? ' is-invalid' : ''); ?> inFld" id="inputGroupFile01" name="soft">
                                             <?php if($errors->has('soft')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('soft')); ?></strong>
                                            </span>
                                            <?php endif; ?>
                                            <span class="custom-file-label" for="inputGroupFile01">Choose file</span>
                                        </div>
                                    <small class="val" id="val-evidence">Allowed Format: xlsx, csv, txt</small>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn  btn-primary reg-btn">Import</button>
                                    </div>
                                </div>
                            </form>
                       </div>     
                    </div>

            <style type="text/css">
                form{
                    padding-left: 100px!important;
                    margin-right: 70px;
                }

                .reg-btn{
                    margin-left: 45% !important;
                }

            </style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/tat/upload_res.blade.php ENDPATH**/ ?>