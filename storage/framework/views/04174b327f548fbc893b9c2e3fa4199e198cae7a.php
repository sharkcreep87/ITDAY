
<?php $__env->startSection('form'); ?>
<div class="note note-danger">
    <p> <strong>Primary Key </strong> must be <strong>show</strong> and in <strong>hidden</strong> type </p>
</div>
<form action="<?php echo e(url('core/model/config/'.$row->module_id.'/form')); ?>" method="post" class="form-horizontal">
    <?php echo e(csrf_field()); ?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered" id="table">
            <thead class="no-border">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Field</th>
                    <th scope="col" width="100"><i class="fa fa-key"></i> Limit To</th>
                    <th scope="col" data-hide="phone">Title / Caption </th>

                    <th scope="col" data-hide="phone">Type </th>
                    <th scope="col" data-hide="phone">Show</th>

                    <th scope="col" data-hide="phone">Searchable</th>
                    <th scope="col" data-hide="phone">Required</th>
                    <th scope="col">&nbsp;</th>
                </tr>
            </thead>
            <tbody class="no-border-x no-border-y">
                <?php 
                    usort($config['forms'], "SiteHelpers::_sort");
                    $i=0; 
                ?>  
                <?php $__currentLoopData = $config['forms']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(!isset($rows['input_group'])) $rows['input_group'] = []; ?>
                <tr>
                    <td>
                        <?php echo e($i + 1); ?>

                        <input type="hidden" name="sortlist[<?php echo e($i); ?>]" value="<?php echo e($i); ?>">
                    </td>
                    <td>
                        <?php echo e($rows['field']); ?>

                    </td>
                    <td>
                        <?php
                            $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
                        ?>
                        <input type="text" class="form-control input-sm" name="limited[<?php echo e($i); ?>]" class="limited" value="<?php echo e($limited_to); ?>" />

                    </td>
                    <td>
                        <input type="text" name="label[<?php echo e($i); ?>]" class="form-control input-sm" value="<?php echo e($rows['label']); ?>" />

                    </td>
                    <td>
                        <?php echo e($rows['type']); ?>

                        <input type="hidden" name="type[<?php echo e($i); ?>]" value="<?php echo e($rows['type']); ?>" />
                    </td>
                    <td>
                        <label class="icheck">
                            <input type="checkbox" name="view[<?php echo e($i); ?>]" value="1" <?php if($rows[ 'view']==1 ): ?> checked <?php endif; ?> />
                        </label>
                    </td>

                    <td>
                        <label class="icheck">
                            <input type="checkbox" name="search[<?php echo e($i); ?>]" value="1" <?php if($rows[ 'search']==1 ): ?> checked <?php endif; ?> />
                        </label>
                    </td>
                    <td>
                        <select name="required[<?php echo e($i); ?>]" id="required" class="form-control input-sm" style="width:150px;">
                            <option value="0" <?php if($rows['required']==1 ): ?> selected <?php endif; ?>>No Required</option>
                            <?php $__currentLoopData = $reqType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($item); ?>" <?php if($rows['required']== $item): ?> selected <?php endif; ?>>
                                <?php echo e($val); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </td>
                    <td>
                        <a href="javascript:void(0)" class="btn btn-xs green editForm" role="button" onclick="_Modal('<?php echo e(url('core/model/config/'.$row->module_id.'/field?form_field='.$rows['field'].'&form_alias='.$rows['alias'])); ?>','Edit Field : <?php echo e($rows['field']); ?>')">
                            <i class="fa fa-cog"></i>
                        </a>
                    </td>

                </tr>
                <?php $i++; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <button type="submit" class="btn green"> Save Changes </button>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>