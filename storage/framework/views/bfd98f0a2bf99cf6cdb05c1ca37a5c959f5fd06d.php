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
                        <span class="caption-subject font-red bold">General Settings</span>
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
                    <?php echo Form::open(array('url'=>'core/settings/general', 'class'=>'form-horizontal','data-parsley-validate'=>'', 'files' => true)); ?>

                    <div class="row">
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Domain</label>
                                <div class="col-md-8">
                                    <input name="cnf_domain" type="text" id="cnf_domain" class="form-control " required value="<?php echo e(env('APP_URL')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Application Name</label>
                                <div class="col-md-8">
                                    <input name="cnf_appname" type="text" id="cnf_appname" class="form-control " required value="<?php echo e(env('APP_NAME')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Application Description</label>
                                <div class="col-md-8">
                                    <textarea name="cnf_appdesc" rows="5" type="text" id="cnf_appdesc" class="form-control"><?php echo e(env('APP_DESC')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Company Name</label>
                                <div class="col-md-8">
                                    <input name="cnf_comname" type="text" id="cnf_comname" class="form-control " value="<?php echo e(env('APP_COMNAME')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">System Email</label>
                                <div class="col-md-8">
                                    <input name="cnf_email" type="text" id="cnf_email" class="form-control " value="<?php echo e(env('APP_EMAIL')); ?>" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Time Zone </label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="cnf_timezone">
                                    <?php $__currentLoopData = $itemzone; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($zone); ?>" <?php if($zone == env('APP_TIME')): ?> selected <?php endif; ?>><?php echo e($zone); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Google Analytic View ID</label>
                                <div class="col-md-8">
                                    <input name="analytic_view_id" type="text" id="cnf_email" class="form-control " value="<?php echo e(env('ANALYTICS_VIEW_ID')); ?>" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class=" control-label col-md-4">Google Analytic View File</label>
                                <div class="col-md-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="analytic_view_file"> 
                                        </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    <?php echo e(env('ANALYTICS_VIEW_FILE')); ?>

                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Metakey </label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="5" name="cnf_metakey"><?php echo e(env('APP_METAKEY')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label col-md-4">Meta Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="5" name="cnf_metadesc"><?php echo e(env('APP_METADESC')); ?></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label col-md-4">Backend Logo</label>
                                <div class="col-md-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="logo"> </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    <p> <i>Please use image dimension 150px * 25px </i> </p>
                                    <div class="logo-placeholder">
                                        <?php if(file_exists(public_path().'/uploads/'.env('APP_LOGO')) && env('APP_LOGO') !=''): ?>
                                        <img src="<?php echo e(asset('uploads/'.env('APP_LOGO'))); ?>" alt="<?php echo e(env('APP_NAME')); ?>" /> 
                                        <?php else: ?>
                                        <img src="<?php echo e(asset('uploads/backend-logo.png')); ?>" alt="<?php echo e(env('APP_NAME')); ?>" /> 
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit">Save changes </button>
                                    <a href="<?php echo e(url()->previous()); ?>" class="btn btn-default" type="submit">Cancel</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">&nbsp;</div>
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