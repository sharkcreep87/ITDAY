 <?php $__env->startSection('content'); ?> <?php usort($tableGrid, "SiteHelpers::_sort") ?>
<div class="page-content">

    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered">
        	<div class="portlet-title">
                <?php if(isset($pageTitle) && isset($pageAction)): ?>
                <div class="caption hidden-xs">
                    <i class=" font-red"></i><span class="caption-subject font-red bold"><?php echo e($pageTitle); ?> : <small> <?php echo e($pageAction); ?></small></span>
                </div>
                <?php endif; ?>
                <div class="grid actions">
                    <?php if($access['is_add'] ==1): ?>
                    <a href="<?php echo e(url('admin/test/update?return='.$return)); ?>" class="tips btn btn-xs green" title="Create <?php echo e($pageTitle); ?>">
                        <i class="fa  fa-plus "></i> <span class="hidden-xs">Create</span></a>
                    <?php endif; ?> <?php if($access['is_remove'] ==1): ?>
                    <a href="javascript://ajax" onclick="_Delete();" class="tips btn btn-xs red" title="Delete <?php echo e($pageTitle); ?>">
                        <i class="fa fa-trash-o"></i> <span class="hidden-xs">Delete</span></a>
                    <?php endif; ?>
                    <a href="javascript:;" class="tips btn btn-xs yellow-gold" onclick="_Modal('<?php echo e(url('admin/test/search?return='.$return)); ?>','Advance Search'); return false;" title="Search <?php echo e($pageTitle); ?>"><i class="fa  fa-search"></i> <span class="hidden-xs">Search</span></a>
                    <?php if($access['is_excel'] ==1): ?>
                    <a href="<?php echo e(url('admin/test/download?return='.$return)); ?>" class="tips btn btn-xs blue" title="Download <?php echo e($pageTitle); ?>">
                        <i class="fa fa-cloud-download"></i> <span class="hidden-xs">Download</span></a>
                    <?php endif; ?>

                    <a href="<?php echo e(url('admin/test')); ?>" class=" tips btn btn-xs btn-default" title="Clear Search"><i class="fa fa-spinner"></i> <span class="hidden-xs"> Clear</span></a>
                </div>
            </div>

            <div class="portlet-body">
                <?php if(session('message')): ?>
                    <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        <?php echo e(session('message')); ?>

                    </div>
                <?php endif; ?>
                <?php if(count($rowData) >= 1): ?>

                <?php echo (isset($search_map) ? $search_map : ''); ?> 
                <?php echo Form::open(array('url'=>'admin/test/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'_Table' )); ?>

                <div class="table-responsive tb_body">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"><span> No </span> </th>
                                <th class="icheck">
                                    <input type="checkbox" class="checkall" />
                                </th>
                                <th><span>Action</span></th>

                                <?php $__currentLoopData = $tableGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($t['view'] =='1'): ?>
                                <?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
                                    <?php if(SiteHelpers::filterColumn($limited )): ?>

                                    <th <?php if(isset($t['width']) && $t['width'] != 'auto'): ?> width="<?php echo e($t['width']); ?>" <?php endif; ?>  align="<?php echo e($t['align']); ?>"><span><?php echo e($t['label']); ?></span></th>
                                    <?php endif; ?> <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $rowData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td width="30"> <?php echo e(++$i); ?> </td>
                                <td width="50" class="icheck">
                                    <input type="checkbox" class="ids" name="ids[]" value="<?php echo e($row->id); ?>" /> </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn red btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <?php if($access['is_detail'] ==1): ?>
                                            <li><a href="<?php echo e(url('admin/test/show/'.$row->id.'?return='.$return)); ?>" class="tips" title="View"><i class="fa  fa-search "></i> View </a></li>
                                            <?php endif; ?> <?php if($access['is_edit'] ==1): ?>
                                            <li><a href="<?php echo e(url('admin/test/update/'.$row->id.'?return='.$return)); ?>" class="tips" title="Edit"><i class="fa fa-edit "></i> Edit </a></li>
                                            <?php endif; ?>
                                        </ul>
                                    </div>

                                </td>

                                <?php $__currentLoopData = $tableGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($field['view'] =='1'): ?>
                                <?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
                                    <?php if(SiteHelpers::filterColumn($limited )): ?>
                                    <td <?php if(isset($field['width']) && $field['width'] != 'auto'): ?> width="<?php echo e($field['width']); ?>" <?php endif; ?> align="<?php echo e($field['align']); ?>">
                                        <?php echo SiteHelpers::formatRows($row->{$field['field']},$field ,$row ); ?>

                                    </td>
                                    <?php endif; ?> <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>
                    <input type="hidden" name="md" value="" />
                </div>
                <?php echo Form::close(); ?> <?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                    <p class="text-center image_background no-result">There is no record!
                        <br />
                        <br />
                        <a href="<?php echo e(url('admin/test/update?return='.$return)); ?>" class="btn btn-danger "><i class="icon-plus-circle2"></i> New <?php echo e($pageTitle); ?> </a>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>