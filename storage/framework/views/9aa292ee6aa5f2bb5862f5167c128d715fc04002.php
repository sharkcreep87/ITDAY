
<?php $__env->startSection('sql'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> SQL</strong> ( Edit SQL of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="<?php echo e(url('core/model/config/'.$row->module_id.'/sql')); ?>" method="post" class="form-vertical" data-parsley-validate>
            <?php echo e(csrf_field()); ?>

            <div class="note note-success">
                <p> You can use query builder tool such <a href="http://code.google.com/p/sqlyog/downloads/list" target="_blank">SQL YOG </a> , PHP MyAdmin , Maestro etc to build your query statment and preview the result ,
                    <br /> then copy the syntac here. </p>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label">SQL SELECT & JOIN</label>
                <textarea name="sql_select" rows="5" id="sql_select" class="tab_behave form-control" placeholder="SQL Select & Join Statement" required><?php echo e($config['sql_select']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label">SQL WHERE CONDITIONAL</label>
                <textarea name="sql_where" rows="2" id="sql_where" class="form-control" placeholder="SQL Where Statement" required><?php echo e($config['sql_where']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label">SQL GROUP</label>
                <textarea name="sql_group" rows="2" id="sql_group" class="form-control" placeholder="SQL Group by Statement"><?php echo e($config['sql_group']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label">SQL ORDER</label>
                <textarea name="sql_order" rows="2" id="sql_order" class="form-control" placeholder="SQL Order by Statement"><?php echo e(@ $config['sql_order']); ?></textarea>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label"></label>
                <button type="submit" class="btn green"> Save SQL </button>
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