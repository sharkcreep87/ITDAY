
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/lib/codemirror.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/dialog/dialog.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/show-hint.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/scroll/simplescrollbars.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/theme/monokai.css')); ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
    .CodeMirror {
        height: 300px !important;
    }
</style>
<?php $__env->startSection('email'); ?>
<form action="<?php echo e(url('core/model/config/'.$row->module_id.'/email')); ?>" method="post" class="form-horizontal" data-parsley-validate>
	<?php echo e(csrf_field()); ?>

	<input type='hidden' name='master' id='master' value='<?php echo e($row->module_name); ?>' />
	<br>
	<div class="form-group <?php echo e($errors->has('to') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-3"> Sent to</label>
	    <div class="col-md-6">
	        <input type="text" name="to" value="<?php echo e(isset($config['email']['to']) ? $config['email']['to']: ''); ?>" class="form-control" required>
	        <?php if($errors->has("to")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("to")); ?></strong>
			</span>
			<?php endif; ?>
			<span class="help-block">
				Can use ',' for multiple email and {$data['email']} or {$data['user']['email']} for variable email.
			</span>
	    </div>
	</div>
	<div class="form-group <?php echo e($errors->has('cc') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-3"> Sent Cc</label>
	    <div class="col-md-6">
	        <input type="text" name="cc" value="<?php echo e(isset($config['email']['cc']) ? $config['email']['cc']: ''); ?>" class="form-control">
	        <?php if($errors->has("cc")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("cc")); ?></strong>
			</span>
			<?php endif; ?>
			<span class="help-block">
				Can use ',' for multiple email
			</span>
	    </div>
	</div>
	<div class="form-group <?php echo e($errors->has('subject') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-3"> Subject Title </label>
	    <div class="col-md-6">
	        <input type="text" name="subject" value="<?php echo e(isset($config['email']['subject']) ? $config['email']['subject']: ''); ?>" class="form-control" required>
	        <?php if($errors->has("subject")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("subject")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>
	<div class="form-group <?php echo e($errors->has('body') ? 'has-error' : ''); ?> ">
	    <label for="ipt" class=" control-label col-md-3"> Subject Title </label>
	    <div class="col-md-8">
	    	<textarea id="email" name="body" class="form-control" rows="10" required><?php echo e(isset($config['email']['body']) ? $config['email']['body']: ''); ?></textarea>
	        <?php if($errors->has("body")): ?>
			<span class="help-block">
				<strong><?php echo e($errors->first("body")); ?></strong>
			</span>
			<?php endif; ?>
	    </div>
	</div>

	<div class="form-group">
	    <label for="ipt" class=" control-label col-md-3"></label>
	    <div class="col-md-6">
	        <button name="submit" type="submit" class="btn green"><i class="fa fa-save"></i> Save Email </button>
	        <?php if(isset($config['email']['subject'])): ?>
	        <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/email/remove')); ?>" class="btn btn-danger" onclick="return confirm('Are you sure want to remove?');"><i class="fa fa-close "></i> Remove </a> 
	        <?php endif; ?>
	    </div>
	</div>

</form>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/lib/codemirror.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/show-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/xml-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/html-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/anyword-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/css-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/javascript-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/hint/sql-hint.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/search/searchcursor.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/search/search.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/dialog/dialog.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/edit/matchbrackets.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/edit/closebrackets.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/comment/comment.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/wrap/hardwrap.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldcode.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/brace-fold.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldcode.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/foldgutter.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/brace-fold.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/xml-fold.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/markdown-fold.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/fold/comment-fold.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/mode/loadmode.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/scroll/simplescrollbars.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/addon/selection/active-line.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/mode/meta.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/mode/xml/xml.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/mode/css/css.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/mode/Javascript/javascript.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/mode/htmlmixed/htmlmixed.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/codemirror/keymap/sublime.js')); ?>" type="text/javascript"></script>
<script type="text/javascript">
    var email = document.getElementById("email");
    var editor = CodeMirror.fromTextArea(email, {
        lineNumbers: true,
        matchBrackets: true,
        styleActiveLine: true,
        mode: "text/html",
        extraKeys: {"Ctrl-Space": "autocomplete"},
        keyMap: "sublime",
        autoCloseBrackets: true,
        showCursorWhenSelecting: true,
        assets: "monokai",
        tabSize: 6,
        foldGutter: true,
        gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
        scrollbarStyle: "simple",
    });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>