
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-screen-tablet font-red"></i>
                        <span class="caption-subject font-red bold">Manage Client</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" onclick="_Modal('<?php echo e(url("core/oauth/create")); ?>','New OAuth Client');" class="btn green"><i class="fa fa-plus"></i> Create New Client</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row no-margin margin-bottom-20">
                        <div class="col-md-12">
                            <!-- <div class="text-right">
                                <a href="javascript:;" class="btn bold">Import table(s)</a>
                            </div> -->
                            <div class="panel panel-default">
                                <?php if(session('message')): ?>
                                    <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        <?php echo e(session('message')); ?>

                                    </div>
                                <?php endif; ?>
                                <!-- <div class="panel-heading"> Panel heading without title </div> -->
                                <div class="panel-body" id="form-content">
                                    <table class="table table-striped">
		                                <thead>
		                                    <tr>
		                                        <th> Client Name </th>
		                                        <th> Client ID </th>
		                                        <th> Client Secret </th>
		                                        <th> Action </th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		                                    <tr>
		                                        <td> <?php echo e($row->name); ?> </td>
		                                        <td> <?php echo e($row->id); ?> </td>
		                                        <td> <?php echo e($row->secret); ?> </td>
		                                        <td>
		                                            <a href="javascript:;" onclick="_Modal('<?php echo e(url("core/oauth/".$row->id."/token")); ?>','Client Access Token');return false;" class="btn btn-sm btn-primary"> Generate Token </a>
		                                            <a href="<?php echo e(url('core/oauth/'.$row->id.'/destroy')); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')"> Delete </a> 
		                                        </td>
		                                    </tr>
		                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		                                </tbody>
		                            </table>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>