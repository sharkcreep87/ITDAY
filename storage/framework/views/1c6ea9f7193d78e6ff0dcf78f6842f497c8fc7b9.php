<form action="<?php echo e(url('core/model')); ?>" method="POST" class="form-horizontal" data-parsley-validate>
    <?php echo e(csrf_field()); ?>

    <input type="hidden" value="<?php echo e(isset($field) ? $field : ''); ?>" name="currentfield">
    <div class="form-group">
        <label class="col-md-4 text-right">Name : </label>
        <div class="col-md-8">
            <input type="text" name="name" value="<?php echo e(isset($field) ? $field : ''); ?>" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 text-right">Note : </label>
        <div class="col-md-8">
            <textarea name="note" rows="3" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 text-right">Choose table : </label>
        <div class="col-md-8">
            <select name="table" class="form-control" >
                <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($t); ?>"><?php echo e($t); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>  
    </div>    

    <div class="form-group">
        <label class="col-md-4"></label>
        <div class="col-md-8 icheck">
            <label class="checkbox"><input type="checkbox" name="active" value="1" /> Active </label>
        </div>  
    </div>
    <div class="form-group">
        <label class="col-md-4"></label>
        <div class="col-md-8 icheck">
            <label class="checkbox"><input type="checkbox" name="type" value="report" /> Create report view only. </label>
        </div>  
    </div>

    <div class="form-group">
        <hr>
        <label class="col-md-4">  </label>
        <div class="col-md-8">
            <button type="submit" class="btn green"> Create Model </button>
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
        </div>  
    </div>
</form>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/icheck/icheck.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $('.icheck input[type="checkbox"],input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });
</script>