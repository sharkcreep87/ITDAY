
 <?php $__env->startSection('content'); ?> <?php usort($tableGrid, "SiteHelpers::_sort") ?>
<div class="page-content">
    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered animated fadeInUp">
            <div class="portlet-title">

            	<?php if(isset($pageTitle) && isset($pageAction)): ?>
                <div class="caption hidden-xs">
                    <span class="caption-subject font-red bold"><?php echo e($pageTitle); ?> : <small> <?php echo e($pageAction); ?></small></span>
                </div>
                <?php endif; ?>
                <div class="actions">
                    <?php if($access['is_remove'] ==1): ?>
                    <a href="javascript://ajax" onclick="_Delete();" class="tips btn btn-xs red" title="Delete">
                        <i class="fa fa-trash-o"></i> <span class="hidden-xs">Delete</span></a>
                    <?php endif; ?>
                    <?php if($access['is_excel'] ==1): ?>
                    <a href="<?php echo e(URL::to('user/logs/download?return='.$return)); ?>" class="tips btn btn-xs blue" title="Download">
                        <i class="fa fa-cloud-download"></i> <span class="hidden-xs">Download</span></a>
                    <?php endif; ?>
                </div>
            </div>
            <div class="portlet-body">

                <?php echo Form::open(array('url'=>'user/logs/delete/', 'class'=>'form-horizontal' ,'id' =>'_Table' )); ?>

                <div class="table-responsive" style="min-height:300px;">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>
                                <th class="icheck">
                                    <input type="checkbox" class="checkall" />
                                </th>

                                <?php $__currentLoopData = $tableGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($t['view'] =='1'): ?>
                                <th><?php echo e($t['label']); ?></th>
                                <?php endif; ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th width="70">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php $__currentLoopData = $rowData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td width="30"> <?php echo e(++$i); ?> </td>
                                <td width="50" class="icheck">
                                    <input type="checkbox" class="ids" name="id[]" value="<?php echo e($row->auditID); ?>" /> </td>
                                <?php $__currentLoopData = $tableGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php if($field['view'] =='1'): ?>
                                    <td>
                                       <?php echo SiteHelpers::formatRows($row->{$field['field']},$field ,$row ); ?> 
                                    </td>
                                    <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <td>
                                    <?php if($access['is_detail'] ==1): ?>
                                    <a href="<?php echo e(URL::to('user/logs/show/'.$row->auditID.'?return='.$return)); ?>" class="tips btn btn-xs btn-white" title="View"><i class="fa  fa-search "></i></a> <?php endif; ?> <?php if($access['is_edit'] ==1): ?>
                                    <a href="<?php echo e(URL::to('user/logs/update/'.$row->auditID.'?return='.$return)); ?>" class="tips btn btn-xs btn-white" title="Edit"><i class="fa fa-edit "></i></a> <?php endif; ?>

                                </td>
                            </tr>

                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tbody>

                    </table>
                    <input type="hidden" name="md" value="" />
                </div>
                <?php echo Form::close(); ?> <?php echo $__env->make('footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->startSection('page_scripts'); ?>
<script>
    $(document).ready(function() {

        $('.do-quick-search').click(function() {
            $('#SximoTable').attr('action', '<?php echo e(URL::to("logs/multisearch")); ?>');
            $('#SximoTable').submit();
        });

    });
</script>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>