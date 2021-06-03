<div class="modal fade" id="self" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title " id="exampleModalLabel">
                    <i class=""></i> <span style="font-weight: bold;">HIV Self Testing</span> 
                </h4>
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
                                        <thead>
                                            <th>Data Element</th>
                                            <th scope="col">Facility</th>
                                            <th scope="col">Community</th>
                                        </thead>
                                        <tbody id="hiv_self_testing" class="preview-table">
                                            <?php $__currentLoopData = $datas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($data->tag === 'hiv_self_testing'): ?>
                                                    <tr id="ind<?php echo e($data->sn); ?>">
                                                        <td><span class="badge-pill badge-primary"><?php echo e($data->sn); ?></span> <?php echo e($data->indicator); ?></td>
                                                        <td class="facility">
                                                            Male < 15yrs <span class="m_less_15 badge-pill badge-secondary">0</span><br>
                                                            Female < 15yrs <span class="f_less_15 badge-pill badge-secondary">0</span><br><br>

                                                            Male > 15yrs <span class="m_great_15 badge-pill badge-secondary">0</span><br>
                                                            Female > 15yrs <span class="f_great_15 badge-pill badge-secondary">0</span>
                                                        </td>
                                                        <td class="community">
                                                            Male < 15yrs <span class="m_less_15 badge-pill badge-secondary">0</span><br>
                                                            Female < 15yrs <span class="f_less_15 badge-pill badge-secondary">0</span><br><br>

                                                            Male > 15yrs <span class="m_great_15 badge-pill badge-secondary">0</span><br>
                                                            Female > 15yrs <span class="f_great_15 badge-pill badge-secondary">0</span>
                                                        </td>
                                                    </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
              </div>
              
            </div>
          </div>
        </div><?php /**PATH C:\laragon\www\qmams\resources\views/layouts/preview/self_testing.blade.php ENDPATH**/ ?>