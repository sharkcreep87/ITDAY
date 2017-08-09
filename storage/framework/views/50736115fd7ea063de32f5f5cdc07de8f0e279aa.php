<?php $__env->startSection('style'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-red"></i>
                        <span class="caption-subject font-red bold">SSH Remote Connection</span>
                    </div>
                    <div class="actions">
                        
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(session('message')): ?>
                        <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?>
                    <?php echo Form::open(array('url'=>'core/settings/connection', 'class'=>'form-horizontal','data-parsley-validate'=>'', 'files' => true)); ?>

                    <div class="row">
                        
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Host IP </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_host" value="<?php echo e(env('REMOTE_HOST')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Username </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_username" value="<?php echo e(env('REMOTE_USERNAME')); ?>" />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Password </label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="cnf_remote_password" value="<?php echo e(env('REMOTE_PASSWORD')); ?>" />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4">Remote SSH Key File</label>
                                <div class="col-sm-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="cnf_remote_key"> 
                                        </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    <?php echo e(env('REMOTE_KEY')); ?>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Key Text </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="cnf_remote_keytext" rows="5"><?php echo e(env('REMOTE_KEYTEXT')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Keyphrase</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="cnf_remote_keyphrase" value="<?php echo e(env('REMOTE_KEYPHRASE')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Agent </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_agent" value="<?php echo e(env('REMOTE_AGENT')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Timeout </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_timeout" value="<?php echo e(env('REMOTE_TIMEOUT')); ?>" />
                                </div>
                            </div>

                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit">Save changes </button>
                                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-default" type="submit"> Cancel </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php echo Form::close(); ?>

                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>