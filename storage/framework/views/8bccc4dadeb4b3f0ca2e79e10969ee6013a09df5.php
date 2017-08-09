
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
                        <span class="caption-subject font-red bold">Pages</span>
                    </div>
                    <div class="actions">
                        <a href="<?php if(count($pages) == 0): ?> <?php echo e(url('core/page/template')); ?> <?php else: ?> <?php echo e(url('core/page/create')); ?> <?php endif; ?>" class="btn tips" title="Create New Page"><i class="fa fa-plus"></i> New Page</a>
                        <a href="javascript:;" class="btn tips" title="Import Page(s)" onclick="_Modal('<?php echo e(url("core/page/import")); ?>', 'Import');"><i class="icon-cloud-upload"></i> Import</a>
                        <a href="javascript:;" class="btn tips" title="Export Page(s)" onclick="_Export('<?php echo e(url("core/page/export")); ?>');"><i class="icon-cloud-download"></i> Export</a>
                        <a href="javascript:;" class="btn tips" title="Delete Page(s)" onclick="_Delete();"><i class="fa fa-remove"></i> Delete</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <?php if(session('message')): ?>
                        <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            <?php echo e(session('message')); ?>

                        </div>
                    <?php endif; ?>
                    <form action="<?php echo e(url('core/page/destroy')); ?>" method="post" id="_Table">
                        <?php echo e(csrf_field()); ?>

                        <div class="table-responsive min-height-500">
                            <?php if(count($pages) >=1): ?>
                            <table class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th class="icheck">
                                            <input type="checkbox" class="checkall" />
                                        </th>
                                        <th>Action</th>
                                        <th>Title</th>
                                        <th>Alias</th>
                                        <th>Method/Url</th>
                                        <th>Type</th>
                                        <th>Meta Title</th>
                                        <th>Created</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td class="icheck">
                                                <input type="checkbox" class="ids" name="ids[]" value="<?php echo e($row->id); ?>" />
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm green dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-settings"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu icons-right">
                                                        <li>
                                                            <a target="_blank" href="<?php echo e(url($row->url)); ?>"><i class="icon-eye"></i> View Page </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?php echo e(url('core/page/'.$row->id.'/edit')); ?>"><i class="icon-note"></i> Edit Page</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="<?php echo e(url('core/page/'.$row->id.'/destroy')); ?>" onclick="return confirm('Are you sure want to delete this page?.');" class="font-red"><i class="icon-trash font-red"></i> Destory</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><a target="_blank" href="<?php echo e(url($row->url)); ?>"><?php echo e($row->title); ?></a></td>
                                            <td><?php echo e($row->alias); ?></td>
                                            <td><span class="uppercase"><?php echo e($row->method); ?>:</span> <?php echo e($row->url); ?></td>
                                            <td><?php echo e($row->type); ?></td>
                                            <td><?php echo e($row->meta_title); ?></td>
                                            <td><?php echo e(date('d/m/Y', strtotime($row->created_at))); ?></td>
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