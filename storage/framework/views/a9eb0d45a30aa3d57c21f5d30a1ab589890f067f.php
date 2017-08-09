
<?php $__env->startSection('info'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Basic Info</strong>  ( Information of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="<?php echo e(url('core/model/config/'.$row->module_id.'/info')); ?>" method="post" class="form-horizontal" data-parsley-validate>
            <?php echo e(csrf_field()); ?>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Name / Title </label>
                <div class="col-md-6">
                    <input type='text' name='module_title' id='module_title' class="form-control " required value='<?php echo e($row->module_title); ?>' />
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Note</label>
                <div class="col-md-6">
                    <textarea name='module_note' id='module_note' rows="3" class="form-control "><?php echo e($row->module_note); ?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Class Controller </label>
                <div class="col-md-6">
                    <input type='text' name='module_name' id='module_name' readonly="1" class="form-control " required value='<?php echo e(ucwords($row->module_name)); ?>Controller' />
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Table</label>
                <div class="col-md-6">
                    <input type='text' name='module_db' id='module_db' readonly="1" class="form-control " required value='<?php echo e($row->module_db); ?>' />

                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4"></label>
                <div class="col-md-6">
                    <button type="submit" name="submit" class="btn green"> Save changes </button>
                </div>
            </div>

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