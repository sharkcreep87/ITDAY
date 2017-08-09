 <?php $__env->startSection('content'); ?>
<div class="page-content">
    <div class="page-content-wrapper">

        <div class="portlet light bordered">
            <div class="portlet-title">
                <?php if(isset($pageTitle) && isset($pageAction)): ?>
                <div class="caption">
                    <i class="icon-user font-red"></i>
                    <span class="caption-subject font-red bold"><?php echo e($pageTitle); ?> : <small> <?php echo e($pageAction); ?></small></span>
                </div>
                <?php endif; ?>
                <div class="actions">
            		<a href="<?php echo e(URL::to('user?return='.$return)); ?>" class="tips btn btn-sm btn-primary red" title="Back"><i class="fa fa-arrow-circle-left"></i> Back</a> <?php if($access['is_add'] ==1): ?>
            		<a href="<?php echo e(URL::to('user/update/'.$id.'?return='.$return)); ?>" class="tips btn btn-primary btn-sm green " title="Edit"><i class="fa fa-edit"></i> Edit</a> <?php endif; ?>
                </div>
            </div>  
            <div class="portlet-body">

                <table class="table table-striped table-bordered">
                    <tbody>

                        <tr>
                            <td width='30%' class='label-view text-right'>Avatar</td>
                            <td>
                                <?php if( file_exists( './uploads/users/'.$row->avatar) && $row->avatar !='') { ?>
                                    <img src="<?php echo e(URL::to('uploads/users').'/'.$row->avatar); ?> " border="0" width="40" class="img-circle" />
                                    <?php  } else { ?>
                                        <img alt="" src="https://www.gravatar.com/avatar/<?php echo e(md5($row->email)); ?>" width="40" class="img-circle" />
                                        <?php } ?>
                            </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Group</td>
                            <td><?php echo e(SiteHelpers::gridDisplayView($row->group_id,'group_id','1:tb_groups:group_id:name')); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Username</td>
                            <td><?php echo e($row->username); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>First Name</td>
                            <td><?php echo e($row->first_name); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Last Name</td>
                            <td><?php echo e($row->last_name); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Email</td>
                            <td><?php echo e($row->email); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Created At</td>
                            <td><?php echo e($row->created_at); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Last Login</td>
                            <td><?php echo e($row->last_login); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Updated At</td>
                            <td><?php echo e($row->updated_at); ?> </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Active</td>
                            <td><?php echo ($row->active ==1 ? '
                                <lable class="label label-success">Active</label>' : '
                                    <lable class="label label-danger">Inactive</label>'); ?> </td>

                        </tr>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>