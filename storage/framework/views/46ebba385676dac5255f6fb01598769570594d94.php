
<?php $__env->startSection('content'); ?>
<?php $__env->startSection('sweet-alert-area'); ?>
    <script src="<?php echo e(asset('assets/js/sweetalert2.js')); ?>" defer></script>
<?php $__env->stopSection(); ?>
                    <div class="row">
                    <?php if(!session('saved')): ?>
                       <div class="col-md-7 edit-form">
                            <h3 class="mt-5 edit-title">Upload Today's <br><span class="styled-header">Radet File</span> </h3>
                            <hr>
                            <form action="<?php echo e(route('import.radet')); ?>" method="post" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <div class="input-group mb-3 col-sm-9 evidence-area">
                                        <div class="input-group-prepend">
                                            <label class="input-group-text">Radet File</label>
                                        </div>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input<?php echo e($errors->has('radet-file') ? ' is-invalid' : ''); ?> inFld" id="inputGroupFile01" name="radet-file">
                                             <?php if($errors->has('radet-file')): ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($errors->first('radet-file')); ?></strong>
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
                            <?php else: ?>
                       </div>
                        <div class="col-md-12" style="margin-left: 40%; margin-top: 20%">
                        <button class="btn btn-info">
                            <a href="<?php echo e(route('analyse')); ?>" style="font-weight: bold; color: white">Analyse Data/Evaluate Performance</a> </button>
                        </div>         
                    </div>
                    <?php endif; ?>
            <style type="text/css">
                form{
                    padding-left: 150px!important;
                }

                .reg-btn{
                    margin-left: 35% !important;
                }

            </style>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\qmams\resources\views/radet/upload.blade.php ENDPATH**/ ?>