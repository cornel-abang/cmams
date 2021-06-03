<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="colorlib.com">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QMAMS - Dhis2 Interface</title>

    <link rel="icon" href="<?php echo e(asset('assets/images/favicon.png')); ?>" type="image/x-icon">

    <!-- Font Icon -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/dhis/fonts/material-icon/css/material-design-iconic-font.min.css')); ?>">

    
    <link rel='stylesheet' href='<?php echo e(asset('assets/dhis/bootstrap/dist/css/bootstrap.min.css')); ?>' type='text/css' />
    <link rel="stylesheet" href="<?php echo e(asset('assets/js/selectize.js-master/dist/css/selectize.bootstrap3.css')); ?>"/>

    <!-- Main css -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/dhis/css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/datatables.css')); ?>">
    <link href="<?php echo e(asset('assets/font-awesome-5/css/all.min.css')); ?>" rel="stylesheet">
    <script type='text/javascript'>
        var page_data = <?php echo pageJsonData(); ?>;
        let errors = [];
        const first = [];
    </script>
</head>
<body style="background: #f8fafc;">

    <div class="main">

        <div class="container">
            <div class="logo-area">
                <div class="logos">
                    <img src="<?php echo e(asset('assets/dhis/images/dhis2.png')); ?>" width="200" height="170" class="img-fluid dhis">
                    <img src="<?php echo e(asset('assets/images/qmams-dhis.png')); ?>" alt="" class="img-fluid q-mams" >
                </div>
                <br>
                <div class="info-txt">
                    <p>
                        This suite serves as a data collection interface for the Dhis software. It is by no means part of the Dhis software per se.
                        Follow the below instructions to ease your data entry process to reduce the margin for error and also save enormous amount of time.<br>
                        
                        
                    </p>
                </div>
            </div>
            <form method="POST" id="signup-form" class="signup-form" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="date-field row">
                    <div class="col-md-6">
                        <small>Facility:</small>
                        <select name="sel-facility" class="form-control col-md-6" id="facility-select">
                            <option value="">Select facility</option>
                            <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($facility->name); ?>"><?php echo e($facility->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <small>Report Date:</small>
                        <input type="date" name="" class="form-control col-md-6">
                    </div>
                </div>
                <h3 >
                    First 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#first">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for First 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'first'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Index Testing 
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#index_testing">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Index Testing">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'index_testing'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Second 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#second">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Seond 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'second'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Third 95
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#third">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Third 95">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'third'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    TB/HIV
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#tbhiv">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for TB">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'tb_hiv'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    PrEP & GBV
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#p_g">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for PrEP & GBV">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'prep_gbv'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    Cervical Cancer
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#c_cancer">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for Cervical Cancer">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'cervicsl_cancer'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HIVST
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#hivst">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HIVST">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'hivst'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HTS Recent
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#hts_recent">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HTS Recent">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'hts_recent'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>

                <h3>
                    HIV Self Testing
                </h3>
                <fieldset>
                    <a class="btn btn-sm btn-primary pull-right preview-btn" data-toggle="modal" data-target="#self">
                        <span class="fa fa-eye" data-toggle="tooltip" title="Preview entries for HIV Self Testing">
                            Preview
                        </span>
                    </a>
                    <div class="form-row">
                        <div class="form-group-flex scrollable-content qst-txt">
                            <div class="form-group">
                                <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($data->indicator  !== ''): ?>
                                        <?php if($data->tag === 'hiv_self_testing'): ?>
                                            <span class="badge-pill badge-secondary"><?php echo e($data->sn); ?></span><a href="" class="btn btn-lg btn-primary btn_<?php echo e($data->sn); ?>" data-toggle="modal" data-target="#indicator<?php echo e($data->id); ?>">
                                                <span data-toggle="tooltip" title="<?php echo e($data->indicator); ?>">
                                                    <?php echo e(\Illuminate\Support\Str::limit($data->indicator, 200, $end='...')); ?>

                                                </span>
                                            </a><br>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>

    </div>
    <form method="POST" id="daily_rep_frm">
    
    <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if($data->indicator !== ''): ?>
            <div class="modal fade" id="indicator<?php echo e($data->id); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <p style="color: #007bff; font-weight: bold;">
                            <?php if($data->tag === 'first'): ?>
                                First 95%
                            <?php elseif($data->tag === 'second'): ?>
                                Second 95%
                            <?php elseif($data->tag === 'third'): ?>
                                Third 95%
                            <?php elseif($data->tag === 'index_testing'): ?>
                                Index Testing
                            <?php elseif($data->tag === 'tb_hiv'): ?>
                                TB/HIV
                            <?php elseif($data->tag === 'prep_gbv'): ?>
                                PrEP & GBV
                            <?php elseif($data->tag === 'cervicsl_cancer'): ?>
                                Cervical Cancer
                            <?php elseif($data->tag === 'hivst'): ?>
                                HIVST
                            <?php elseif($data->tag === 'hts_recent'): ?>
                                HTS Recent
                            <?php elseif($data->tag === 'hiv_self_testing'): ?>
                                HIV Self Testing
                            <?php endif; ?>
                        </p>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <div style="background: #f8fafc; font-size: 16px; text-align: center; padding: 7px;">
                        <p><?php echo e($data->indicator); ?></p>
                    </div>
                    
                        <?php echo csrf_field(); ?>
                        <?php $i=0 ?>

                        <input type="hidden" name="indicator[]" value="<?php echo e($data->sn); ?>">
                      <h2>Facility</h2><br>
                      <div class="form-group row">

                        <?php if($data->special !== 'females'): ?>

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Male</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding: 5px">< 15yrs</label>
                          <input type="number" name="f_m_l15[]" class="form-control facility indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_m_less_15 <?php echo e($data->sn == '29'?'i_28_29':''); ?>"  data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".m_less_15" data-from=".facility" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_m_less_15" value="0">
                          <span class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </span>

                          <?php if($data->special !== 'less_than_15'): ?>
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="f_m_g15[]" class="form-control facility indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_m_great_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".m_great_15" data-from=".facility" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_m_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>
                          <?php endif; ?>

                        </div>

                        <?php endif; ?>

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Female</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding: 5px"> < 15yrs</label>
                          <input type="number" name="f_f_l15[]" class="form-control facility indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_f_less_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".f_less_15" data-from=".facility" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_f_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>

                          <?php if($data->special !== 'less_than_15'): ?>
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="f_f_g15[]" class="form-control facility indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_f_great_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".f_great_15" data-from=".facility" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_f_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>
                          <?php endif; ?>
                        </div>
                      </div>
                      <?php if($data->sn != 1): ?>
                      <h2>Community</h2><br>
                      <div class="form-group row">

                        <?php if($data->special !== 'females'): ?>
                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Male</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" name="c_m_l15[]" class="form-control community indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_m_less_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".m_less_15" data-from=".community" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_m_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>

                          <?php if($data->special !== 'less_than_15'): ?>
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="c_m_g15[]" class="form-control community indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_m_great_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".m_great_15" data-from=".community" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_m_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>
                          <?php endif; ?>

                        </div>
                        <?php endif; ?>

                        <label for="inputPassword" class="col-sm-2 col-form-label" style="font-size: 18px; font-weight: bold;">Female</label>
                        <div class="col-sm-4">
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> < 15yrs</label>
                          <input type="number" name="c_f_l15[]" class="form-control community indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_f_less_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".f_less_15" data-from=".community" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_f_less_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>

                          <?php if($data->special !== 'less_than_15'): ?>
                          <label style="font-size: 12px; font-weight: bold; padding-top: 10% !important"> > 15yrs</label>
                          <input type="number" name="c_f_g15[]" class="form-control community indicator prev_in indicator_<?php echo e($data->sn); ?> tag_<?php echo e($data->sn); ?> <?php echo e($data->sn == '22ix'?'elem_21_22v':''); ?> <?php echo e($data->sn == '67'?'elem_67_68':''); ?> <?php echo e($data->sn == '68'?'elem_67_68':''); ?> demo_f_great_15" data-sn="<?php echo e($data->sn); ?>" data-greater="<?php echo e($data->not_greater_than??0); ?>" data-tag="<?php echo e($data->tag); ?>" data-pointer=".f_great_15" data-from=".community" data-indicator="#ind<?php echo e($data->sn); ?>" data-demo="demo_f_great_15" value="0">
                          <div class="errorHide">
                            <p class="errorMsg" data-toggle="tooltip" title="<?php echo e($data->validation_text); ?>">
                                <?php echo e(\Illuminate\Support\Str::limit($data->validation_text, 40, $end='...')); ?> 
                            </p>
                          </div>
                          <?php endif; ?>

                        </div>
                      </div>

                      
                      <?php endif; ?>
                    
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Save</button>
                    
                  </div>
                </div>
              </div>
            </div>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <?php echo $__env->make('layouts.preview.first', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.second', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.third', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.tb_hiv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.prep_gbv', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.cervical_cancer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.hivst', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.hts_recent', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.index_testing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('layouts.preview.self_testing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <style type="text/css">
        form h3{
            font-size: 13px;
            font-weight: bold;
        }

        .steps ul li a{
            height: 50px;
        }

        .errorMsg{
          color: red !important;
          font-size: 11px;
        }

        .errorHide{
            display: none;
        }

        .errorShow{
            display: inline-block;
        }

        .errorSig{
            border: 1px solid red;
        }

        .shutDown{
            display: none !important;
        }

        .badge-secondary, .badge-success{
            font-weight: bold;
        }

        .scrollable-content.qst-txt{
            height: 300px;
        }

        .scrollable-content.qst-txt a.btn{
            margin: 0!important;
        }

        .preview-btn{
            color: white!important;
            font-weight: bold;
            margin-bottom: 10px;
            padding: 10px;
        }

        .preview-btn i span{
            font-weight: bold !important;
        }

        fieldset{
            margin-top: -40px !important;
        }

        .preview-table tr td:first-child{
            width: 400px;
        }

        .date-field{
            margin-top: 20px;
        }

        .date-field small{
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>

    <!-- JS -->
    <script src="<?php echo e(asset('assets/dhis/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dhis/vendor/jquery-validation/dist/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dhis/vendor/jquery-validation/dist/additional-methods.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dhis/vendor/jquery-steps/jquery.steps.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/dhis/js/main.js')); ?>"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset('assets/js/datatable/datatables/jquery.dataTables.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/datatable/datatables/datatable.custom.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/selectize.js-master/dist/js/standalone/selectize.min.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>
    <script src='<?php echo e(asset('assets/dhis/bootstrap/dist/js/bootstrap.min.js')); ?>'></script>
</body>
</html><?php /**PATH C:\laragon\www\qmams\resources\views/dhis/index.blade.php ENDPATH**/ ?>