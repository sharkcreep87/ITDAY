
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
                        <i class="icon-graph font-red"></i>
                        <span class="caption-subject font-red bold">Graph APIs</span>
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
                    <ul class="nav nav-tabs margin-top-10">
                        <li class="<?php if(Request::segment(4)== 'index'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/graph/'.$row->module_id.'/index')); ?>" >List <?php echo e($row->module_name); ?> </a></li>
                        <li class="<?php if(Request::segment(4)== 'create'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/graph/'.$row->module_id.'/create')); ?>" >Create <?php echo e($row->module_name); ?> </a></li>
                        <li class="<?php if(Request::segment(4)== 'show'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/graph/'.$row->module_id.'/show')); ?>" >Retrieve <?php echo e($row->module_name); ?></a></li>
                        <li class="<?php if(Request::segment(4)== 'update'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/graph/'.$row->module_id.'/update')); ?>" >Update <?php echo e($row->module_name); ?></a></li>
                        <li class="<?php if(Request::segment(4)== 'destroy'): ?> active <?php endif; ?>"><a href="<?php echo e(url('core/graph/'.$row->module_id.'/destroy')); ?>" >Delete <?php echo e($row->module_name); ?></a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- INDEX -->
                        <div class="tab-pane <?php if(Request::segment(4)== 'index'): ?> active <?php endif; ?>">
                            <?php echo $__env->yieldContent('index'); ?>
                        </div>
                        <!-- END INDEX -->
                        <!-- CREATE -->
                        <div class="tab-pane <?php if(Request::segment(4)== 'create'): ?> active <?php endif; ?>">
                            <?php echo $__env->yieldContent('create'); ?>
                        </div>
                        <!-- END CREATE -->
                        <!-- SHOW -->
                        <div class="tab-pane <?php if(Request::segment(4)== 'show'): ?> active <?php endif; ?>">
                            <?php echo $__env->yieldContent('show'); ?>
                        </div>
                        <!-- END SHOW -->
                        <!-- UPDATE -->
                        <div class="tab-pane <?php if(Request::segment(4)== 'update'): ?> active <?php endif; ?>">
                            <?php echo $__env->yieldContent('update'); ?>
                        </div>
                        <!-- END UPDATE -->
                        <!-- DESTROY -->
                        <div class="tab-pane <?php if(Request::segment(4)== 'destroy'): ?> active <?php endif; ?>">
                            <?php echo $__env->yieldContent('destroy'); ?>
                        </div>
                        <!-- END DESTROY -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>