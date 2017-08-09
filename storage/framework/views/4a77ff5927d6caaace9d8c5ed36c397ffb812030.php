
<?php $__env->startSection('style'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red bold">Configuration</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="<?php if(Request::segment(5)== 'info'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/info')); ?>"><i class="icon-bulb"></i> Basic Info</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'sql'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/sql')); ?>"><i class="fa fa-database"></i> SQL</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'table'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/table')); ?>"><i class="fa fa-list"></i> Table</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'form' || Request::segment(5)== 'subform' || Request::segment(5)== 'formdesign'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/form')); ?>"><i class="icon-note"></i> Form</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'relation'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/relation')); ?>"><i class="fa fa-link"></i> Relation</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'permission'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/permission')); ?>"><i class="icon-lock-open"></i> Permission</a>
                        </li>
                        <li class="<?php if(Request::segment(5)== 'email' || Request::segment(5)== 'sms'): ?> active <?php endif; ?>">
                            <a href="<?php echo e(url('core/model/config/'.$row->module_id.'/email')); ?>"><i class="icon-envelope-open"></i> Notification</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        <?php if(session('message')): ?>
                            <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                <?php echo e(session('message')); ?>

                            </div>
                        <?php endif; ?>
                        <!-- INFO TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'info'): ?> active <?php endif; ?>" id="tab_1_1">
                            <?php echo $__env->yieldContent('info'); ?>
                        </div>
                        <!-- END INFO TAB -->
                        <!-- SQL TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'sql'): ?> active <?php endif; ?>" id="tab_1_2">
                            <?php echo $__env->yieldContent('sql'); ?>
                        </div>
                        <!-- END SQL TAB -->
                        <!-- TABLE TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'table'): ?> active <?php endif; ?>" id="tab_1_3">
                            <?php echo $__env->yieldContent('table'); ?>
                        </div>
                        <!-- END TABLE TAB -->
                        <!-- FORM TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'form' || Request::segment(5)== 'subform' || Request::segment(5)== 'formdesign'): ?> active <?php endif; ?>" id="tab_1_4">
                            <div class="portlet light portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Form</strong> (Change form settings of Model )</span>
                                    </div>
                                    <div class="actions">
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs margin-top-10">
                                        <li class="<?php if(Request::segment(5)== 'form'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/form')); ?>" >Form Configuration </a></li>
                                        <li class="<?php if(Request::segment(5)== 'subform'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/subform')); ?>" >Sub Form </a></li>
                                        <li class="<?php if(Request::segment(5)== 'formdesign'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/formdesign')); ?>" >Form Layout</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- FORM CONFIGURATION -->
                                        <div class="tab-pane <?php if(Request::segment(5)== 'form'): ?> active <?php endif; ?>" id="tab_2_1">
                                            <?php echo $__env->yieldContent('form'); ?>
                                        </div>
                                        <!-- END FORM CONFIGURATION -->
                                        <!-- SUB FORM -->
                                        <div class="tab-pane <?php if(Request::segment(5)== 'subform'): ?> active <?php endif; ?>" id="tab_2_2">
                                            <?php echo $__env->yieldContent('subform'); ?>
                                        </div>
                                        <!-- END SUB FORM -->
                                        <!-- FORM LAYOUT -->
                                        <div class="tab-pane <?php if(Request::segment(5)== 'formdesign'): ?> active <?php endif; ?>" id="tab_2_3">
                                            <?php echo $__env->yieldContent('formdesign'); ?>
                                        </div>
                                        <!-- END FORM LAYOUT -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM TAB -->
                        <!-- RELATION TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'relation'): ?> active <?php endif; ?>" id="tab_1_5">
                            <?php echo $__env->yieldContent('relation'); ?>
                        </div>
                        <!-- END RELATION TAB -->
                        <!-- PERMISSION TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'permission'): ?> active <?php endif; ?>" id="tab_1_6">
                            <?php echo $__env->yieldContent('permission'); ?>
                        </div>
                        <!-- END PERMISSION TAB -->
                        <!-- NOTIFI TAB -->
                        <div class="tab-pane <?php if(Request::segment(5)== 'email' || Request::segment(5)== 'sms'): ?> active <?php endif; ?>" id="tab_1_7">
                            <div class="portlet light portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Notification</strong></span>
                                    </div>
                                    <div class="actions">
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs margin-top-10">
                                        <li class="<?php if(Request::segment(5)== 'email'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/email')); ?>" >Email Notification</a></li>
                                        <!-- <li class="<?php if(Request::segment(5)== 'sms'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/model/config/'.$row->module_id.'/sms')); ?>" >SMS</a></li> -->
                                    </ul>
                                    <div class="tab-content">
                                        <!-- EMAIL -->
                                        <div class="tab-pane <?php if(Request::segment(5)== 'email'): ?> active <?php endif; ?>" id="tab_3_1">
                                            <?php echo $__env->yieldContent('email'); ?>
                                        </div>
                                        <!-- END EMAIL -->
                                        <!-- SUB SMS -->
                                        <!-- <div class="tab-pane <?php if(Request::segment(5)== 'sms'): ?> active <?php endif; ?>" id="tab_3_2">
                                            <?php echo $__env->yieldContent('sms'); ?>
                                        </div> -->
                                        <!-- END SUB SMS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END NOTIFI TAB -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>