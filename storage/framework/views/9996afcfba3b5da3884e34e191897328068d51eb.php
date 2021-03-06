
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
                        <span class="caption-subject font-red bold">Models</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" class="btn tips" title="Create New Model" onclick="_Modal('<?php echo e(url("core/model/create")); ?>', 'New Model');"><i class="fa fa-plus"></i> New Model</a>
                        <a href="javascript:;" class="btn tips" title="Rebuild Model(s)" onclick="_Rebuild();"><i class="icon-reload"></i> Rebuild</a>
                        <a href="javascript:;" class="btn tips" title="Import Model(s)" onclick="_Modal('<?php echo e(url("core/model/import")); ?>', 'Import');"><i class="icon-cloud-upload"></i> Import</a>
                        <a href="javascript:;" class="btn tips" title="Export Model(s)" onclick="_Export('<?php echo e(url("core/model/export")); ?>');"><i class="icon-cloud-download"></i> Export</a>
                        <a href="javascript:;" class="btn tips" title="Delete Model(s)" onclick="_Delete();"><i class="fa fa-remove"></i> Delete</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(session('message')): ?>
                        <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(url('core/model/destory')); ?>" method="post" id="_Table">
                        <?php echo e(csrf_field()); ?>

                        <div class="table-responsive min-height-500">
                            <?php if(count($modules) >=1): ?>
                            <table class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th>Action</th>
                                        <th class="icheck">
                                            <input type="checkbox" class="checkall" />
                                        </th>
                                        <th>Module Name</th>
                                        <th>Shortcode</th>
                                        <th>Controller</th>
                                        <th>Database Table</th>
                                        <th>PRI KEY</th>
                                        <th>Created</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm green dropdown-toggle" data-toggle="dropdown">
                                                    <i class="icon-settings"></i> <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu icons-right">
                                                    <li><a target="_blank" href="<?php echo e(url('admin/'.strtolower($row->module_name))); ?>"><i class="icon-eye"></i> View Model </a></li>
                                                    <li><a href="<?php echo e(url('core/model/config/'.$row->module_id)); ?>/info"><i class="icon-settings"></i> Configuration</a></li>
                                                    <li><a href="<?php echo e(url('core/model/rebuild/'.$row->module_id)); ?>"><i class="icon-reload"></i> Rebuild Model</a></li>
                                                    <li><a href="<?php echo e(url('core/table/'.$row->module_db.'/edit')); ?>"><i class="icon-note"></i> Edit Table</a></li>
                                                    <li class="divider"></li>
                                                    <li><a href="<?php echo e(url('core/model/'.$row->module_id.'/destory?_delete=module')); ?>" onclick="return confirm('Are you sure want to delete this model?.');" class="font-red"><i class="icon-trash font-red"></i> Destory</a></li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="icheck">
                                            <input type="checkbox" class="ids" name="ids[]" value="<?php echo e($row->module_id); ?>" /> </td>
                                        <td><a href="<?php echo e(url('core/model/config/'.$row->module_id)); ?>/info"> <?php echo e($row->module_title); ?> </a></td>
                                        <td style="font-size: 10px">
                                            <b>APIs[Restful] : </b><a href="<?php echo e(url('core/graph/'.$row->module_id.'/index')); ?>" target="_blank"> <?php echo e(url('api/'.strtolower($row->module_name))); ?></a><br />
                                            <b>Model : </b>use App\Models\<?php echo e(ucwords($row->module_name)); ?>

                                        </td>
                                        <td><?php echo e(ucwords($row->module_name).'Controller'); ?> </td>
                                        <td><?php echo e($row->module_db); ?> </td>
                                        <td><?php echo e($row->module_db_key); ?> </td>
                                        <td><?php echo e(date('d/m/y',strtotime($row->module_created))); ?> </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <?php endif; ?>
                        </div>
                    </form>
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