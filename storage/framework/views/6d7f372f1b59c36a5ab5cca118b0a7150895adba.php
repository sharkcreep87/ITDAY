
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
                        <i class="fa fa-database font-red"></i>
                        <span class="caption-subject font-red bold">Database Tables</span>
                    </div>
                    <div class="actions">
                        <a href="<?php echo e(url('core/table/create')); ?>" class="btn tips" title="Create New Table"><i class="fa fa-plus"></i> New Table </a>
                        <a href="javascript:;" class="btn tips" title="Create New View" onclick="_Modal('<?php echo e(url("core/view")); ?>', 'Create View');"><i class="fa fa-plus"></i>  New View </a>
                        <a href="javascript:;" class="btn tips" title="Import SQL File" onclick="_Modal('<?php echo e(url("core/table/import")); ?>', 'Import Table');"><i class="fa fa-upload"></i>  Import Table </a>
                        <a href="javascript:;" class="btn tips" title="Delete Table(s)" onclick="_Delete()"><i class="fa fa-remove"></i>  Delete </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <?php if(session('message')): ?>
                                <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    <?php echo e(session('message')); ?>

                                </div>
                            <?php endif; ?>
                            <?php if(count($errors) > 0): ?>
                                <div class="alert alert-danger">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <p><?php echo e($error); ?></p>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                            <div class="tabbable-custom ">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab"> Manage Tables </a>
                                    </li>
                                    <li>
                                        <a href="#tab_5_2" data-toggle="tab"> Manage Views </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_5_1">
                                        <form action="<?php echo e(url('core/table/delete')); ?>" method="post" id="_Table">
                                            <?php echo e(csrf_field()); ?>

                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="30" class="icheck">
                                                                <input type="checkbox" class="checkall" />
                                                            </th>
                                                            <th> Table Name </th>
                                                            <th> Engine </th>
                                                            <th> Collation </th>
                                                            <th> Data Rows </th>
                                                            <th> Create At </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($tb['info']->Engine != null): ?>
                                                            <tr>
                                                                <td class="icheck">
                                                                    <input type="checkbox" class="ids" name="tables[]" value="<?php echo e($tb['name']); ?>" /> </td>
                                                                </td>
                                                                <td>
                                                                    <?php echo e($tb['info']->Name); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($tb['info']->Engine); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($tb['info']->Collation); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($tb['info']->Rows); ?>

                                                                </td>
                                                                <td>
                                                                    <?php echo e($tb['info']->Create_time); ?>

                                                                </td>
                                                                <td>
                                                                    <a href="<?php echo e(url('core/table/'.$tb['name'].'/edit')); ?>" class="btn btn-xs green" ><i class="fa fa-edit "></i></a>
                                                                    <a href="<?php echo e(url('core/table/'.$tb['name'].'/remove')); ?>" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>

                                                </table>

                                            </div>
                                        </form>
                                        
                                    </div>
                                    <div class="tab-pane" id="tab_5_2">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="30">
                                                            No.
                                                        </th>
                                                        <th> View Name </th>
                                                        <th width="150"> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php  $i = 1;  ?>
                                                    <?php $__currentLoopData = $tables; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($tb['info']->Engine == null): ?>
                                                        <tr>
                                                            <td class="icheck">
                                                                <?php echo e($i); ?>

                                                            </td>
                                                            <td>
                                                                <?php echo e($tb['info']->Name); ?>

                                                            </td>
                                                            <td>
                                                                <a href="<?php echo e(url('core/view/'.$tb['name'].'/remove')); ?>" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                                                            </td>
                                                        </tr>
                                                        <?php  $i++;  ?>
                                                    <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin margin-bottom-20">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>