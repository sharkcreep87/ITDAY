
<?php $__env->startSection('relation'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Relation</strong> ( Add relation of Model) </span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
    	<form action="<?php echo e(url('core/model/config/'.$row->module_id.'/relation')); ?>" method="post" class="form-horizontal" data-parsley-validate>
    		<?php echo e(csrf_field()); ?>

	        <input type='hidden' name='master' id='master' value='<?php echo e($row->module_name); ?>' />
	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"> Link Title <code>*</code></label>
	            <div class="col-md-6">
	                <input type="text" name="title" class="form-control" required>
	                <i class="text-danger"> Important ! ,  <small> Do  not use white space </small></i>
	            </div>
	        </div>

	        <div class="form-group">
	            <label class="control-label col-md-4"> Relation Type : </label>
	            <div class="col-md-6 radio-group icheck">
	                <input type="radio" name="relation" value="belongsTo" checked /> belongsTo
	                <input type="radio" name="relation" value="hasMany" /> hasMany
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Master Key <code>*</code></label>
	            <div class="col-md-6">

	                <select name="master_key" id="master_key" required="true" class="form-control">
	                    <?php $__currentLoopData = $config['grid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($field['field']); ?>">
                            <?php echo e($field['field']); ?>

                        </option>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"> Relation Model </label>
	            <div class="col-md-6">
	                <select name="module" id="module" required="true" class="form-control">
	                    <option value="">-- Select Model --</option>
	                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $module): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($module->module_name); ?>">
                            <?php echo e($module->module_title); ?>

                        </option>
	                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Relation Table <code>*</code></label>
	            <div class="col-md-6">
	                <select name="table" id="table" required="true" class="form-control">
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Detail Key <code>*</code></label>
	            <div class="col-md-6">
	                <select name="key" id="key" required="true" class="form-control">
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"></label>
	            <div class="col-md-6">
	                <button name="submit" type="submit" class="btn green"> Save Form </button>
	            </div>
	        </div>

	    </form>

        <div class="table-responsive" style="margin-bottom:40px;">

            <table class="table table-striped">
                <thead class="no-border">
                    <tr>
                        <th>Title</th>
                        <th>Relation Type</th>
                        <th>Master Key</th>
                        <th>Relation Model</th>
                        <th data-hide="phone">Relation Table</th>
                        <th data-hide="phone">Relation Key</th>
                        <th data-hide="phone">Action</th>
                    </tr>
                </thead>
                <tbody class="no-border-x no-border-y">
                    <?php $__currentLoopData = $config['subgrid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <?php echo e($rows['title']); ?>

                        </td>
                        <td>
                            <?php echo e($rows['relation']); ?>

                        </td>
                        <td>
                            <?php echo e($rows['master_key']); ?>

                        </td>
                        <td>
                            <?php echo e($rows['module']); ?>

                        </td>
                        <td>
                            <?php echo e($rows['table']); ?>

                        </td>
                        <td>
                            <?php echo e($rows['key']); ?>

                        </td>
                        <td><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/relation/remove?module='.$rows['module'])); ?>" onclick="return confirm('Are you sure want to delete?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a></td>

                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </tbody>

            </table>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript" >
    $(document).ready(function() {
        $("#table").jCombo("<?php echo e(url('core/model/combotable')); ?>", {});
        $("#key").jCombo("<?php echo e(url('core/model/combotablefield')); ?>?table=", {
            parent: "#table"
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>