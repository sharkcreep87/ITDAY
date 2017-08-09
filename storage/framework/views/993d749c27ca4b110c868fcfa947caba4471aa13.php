
<?php $__env->startSection('subform'); ?>
<form action="<?php echo e(url('core/model/config/'.$row->module_id.'/subform')); ?>" method="post" class="form-horizontal" data-parsley-validate>
	<?php echo e(csrf_field()); ?>

	<input type='hidden' name='master' id='master' value='<?php echo e($row->module_name); ?>' />
	<div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4"> Subform Title <code>*</code></label>
	    <div class="col-md-6">
	        <input type="text" name="title" value="<?php echo e(isset($config['subform']['title']) ? $config['subform']['title']: ''); ?>" class="form-control" required>
	        <?php if($errors->has("title")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("title")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group <?php echo e($errors->has('master_key') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4">Master Form Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="master_key" id="master_key" required="true" class="form-control">
	            <?php $__currentLoopData = $config['grid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	            <option value="<?php echo e($field['field']); ?>" <?php if(isset($config['subform'][ 'master_key']) && $config['subform'][ 'master_key']==$field[ 'field']): ?> selected <?php endif; ?>>
	                <?php echo e($field['field']); ?>

	            </option>
	            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	        </select>
	        <?php if($errors->has("master_key")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("master_key")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group <?php echo e($errors->has('module') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4"> Take <b>FORM</b> from Model </label>
	    <div class="col-md-6">
	        <select name="module" id="module" required="true" class="form-control">
	            <option value="">-- Select Model --</option>
	            <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
	                <option value="<?php echo e($module->module_name); ?>" <?php if(isset($config['subform']['module']) && $config['subform'][ 'module']==$module->module_name): ?>  selected <?php endif; ?> >
	                    <?php echo e($module->module_title); ?>

	                </option>
	            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	        </select>
	        <?php if($errors->has("module")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("module")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>
	<div class="form-group <?php echo e($errors->has('module_table') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Table <code>*</code></label>
	    <div class="col-md-6">
	        <select name="table" id="module_table" required="true" class="form-control">
	        </select>
	        <?php if($errors->has("module_table")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("module_table")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group <?php echo e($errors->has('primary_key') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Primary Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="primary_key" id="primary_key" required="true" class="form-control">
	        </select>
	        <?php if($errors->has("primary_key")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("primary_key")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group <?php echo e($errors->has('key') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Relation Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="key" id="key" required="true" class="form-control">
	        </select>
	        <?php if($errors->has("key")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("key")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group">
	    <label for="ipt" class=" control-label col-md-4"></label>
	    <div class="col-md-6">
	        <button name="submit" type="submit" class="btn green"><i class="fa fa-save"></i> Save Form </button>
	        <?php if(isset($config['subform']['master_key'])): ?>
	        <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/subform/remove')); ?>" class="btn btn-danger" onclick="return confirm('Are you sure want to remove?');"><i class="fa fa-close "></i> Remove </a> 
	        <?php endif; ?>
	    </div>
	</div>

</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('.format_info').popover()

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function(i) {
                    $(this).html(i + 1);
                });
                $('.reorder', ui.item.parent()).each(function(i) {
                    $(this).val(i + 1);
                });
            };

        $("#table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        });

        $("#module_table").jCombo("<?php echo e(url('core/model/combotable')); ?>", {
            selected_value: "<?php echo e((isset($config['subform']['table']) ? $config['subform']['table']: null )); ?>"
        });
        $("#primary_key").jCombo("<?php echo e(url('core/model/combotablefield')); ?>?table=", {
            parent: "#module_table",
            selected_value: "<?php echo e((isset($config['subform']['primary_key']) ? $config['subform']['primary_key']: null )); ?>"
        });
        $("#key").jCombo("<?php echo e(url('core/model/combotablefield')); ?>?table=", {
            parent: "#module_table",
            selected_value: "<?php echo e((isset($config['subform']['key']) ? $config['subform']['key']: null )); ?>"
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>