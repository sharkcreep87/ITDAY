
<?php $__env->startSection('permission'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Permission</strong> ( Manage permission of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="<?php echo e(url('core/model/config/'.$row->module_id.'/permission')); ?>" method="post" class="form-vertical" data-parsley-validate>
            <?php echo e(csrf_field()); ?>

            <table class="table table-striped table-bordered" id="table">
                <thead class="no-border">
                    <tr>
                        <th field="name1" width="20">No</th>
                        <th field="name2">Group </th>
                        <?php $__currentLoopData = $config['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th field="name3" data-hide="phone">
                            <?php echo e($val); ?>

                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tr>
                </thead>
                <tbody class="no-border-x no-border-y">
                	<?php $__currentLoopData = $access; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i=>$group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td width="20">
                        	<?php echo e($group['group_id']); ?>

                            <input type="hidden" name="group_id[]" value="<?php echo e($group['group_id']); ?>" />
                        </td>
                        <td>
                            <?php echo e($group['group_name']); ?>

                        </td>
                        <?php $__currentLoopData = $config['tasks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="">
                            <label class="icheck">
                                <input name="<?php echo e($item); ?>[<?php echo e($group['group_id']); ?>]" class="c<?php echo e($group['group_id']); ?>" type="checkbox" value="1" <?php if($group[$item]==1): ?> checked <?php endif; ?> />
                            </label>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
            <button type="submit" class="btn green"> Save Changes </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>