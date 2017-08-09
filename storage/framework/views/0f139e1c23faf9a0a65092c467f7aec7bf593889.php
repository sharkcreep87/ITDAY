 

<?php $__env->startSection('content'); ?>

<div class="page-content">

    <div class="page-content-wrapper">

        <?php echo Form::open(array('url'=>'user/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')); ?>

        <div class="portlet light bordered">
            <div class="portlet-title">
                <?php if(isset($pageTitle) && isset($pageAction)): ?>
                <div class="caption">
                    <i class="icon-user font-red"></i>
                    <span class="caption-subject font-red bold"><?php echo e($pageTitle); ?> : <small> <?php echo e($pageAction); ?></small></span>
                </div>
                <?php endif; ?>
                <div class="actions">
                    
                </div>
            </div>
            <div class="portlet-body">
                <?php if(count($errors->all()) > 0): ?>
                <div class="note note-danger">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <p><?php echo e($error); ?></p>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
                <?php endif; ?>

                <div class="form col-xs-12 col-md-7">

                    <div class="form-group hidethis " style="display:none;">
                        <label for="Id" class=" control-label col-xs-12 col-md-4 text-left"> Id </label>
                        <div class=" col-xs-12 col-md-6">
                            <?php echo Form::text('id', $row['id'],array('class'=>'form-control', 'placeholder'=>'')); ?>

                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Group / Level" class=" control-label col-xs-12 col-md-4 text-left"> Group / Level <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            <select name='group_id' rows='5' id='group_id' code='{$group_id}' class='form-control select2' required></select>
                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Username" class=" control-label col-xs-12 col-md-4 text-left"> Username <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            <?php echo Form::text('username', $row['username'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )); ?>

                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="First Name" class="col-xs-12 control-label col-md-4 text-left"> First Name <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            <?php echo Form::text('first_name', $row['first_name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )); ?>

                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Last Name" class="col-xs-12 control-label col-md-4 text-left"> Last Name </label>
                        <div class="col-xs-12 col-md-6">
                            <?php echo Form::text('last_name', $row['last_name'],array('class'=>'form-control', 'placeholder'=>'Last Name', 'required'=>'true' )); ?>

                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Email" class="col-xs-12 control-label col-md-4 text-left"> Email <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            <?php echo Form::text('email', $row['email'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true', 'parsley-type'=>'email' )); ?>

                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>

                    <div class="form-group  ">
                        <label for="Status" class="col-xs-12 control-label col-md-4 text-left"> Status <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">

                            <label class='radio radio-inline'>
                                <input type='radio' name='active' value='0' class="icheck" required <?php if($row[ 'active']=='0' ): ?> checked="checked" <?php endif; ?>> Inactive </label>
                            <label class='radio radio-inline'>
                                <input type='radio' name='active' value='1' class="icheck" required <?php if($row[ 'active']=='1' ): ?> checked="checked" <?php endif; ?>> Active </label>
                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>

                    <!-- Image  -->
                    <div class="form-group   " >
                        <label for="Image" class=" control-label col-xs-12 col-md-4 text-left"> Image </label>
                        <div class="col-xs-12 col-md-7">
                            <div class="form-control fileinput fileinput-new <?php if($row['avatar'] ==''): ?> required <?php endif; ?> " data-provides="fileinput" style="border: none;">
                                <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;">
                                <?php if($row['avatar'] !=''): ?>
                                    <img src="<?php echo e(asset('uploads/users/'.$row["avatar"])); ?>" alt="" />
                                <?php else: ?>
                                    <img src="https://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image" alt="" />
                                <?php endif; ?>
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 200px; max-height: 150px;"> </div>
                                <div>
                                    <span class="btn default btn-file">
                                        <span class="fileinput-new"> Select image </span>
                                        <span class="fileinput-exists"> Change </span>
                                        <input type="file" name="avatar" id="image"> </span>
                                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                </div>
                            </div>
                        </div>  
                        <div class="col-xs-12 col-md-2">
                        </div>
                    </div>

                </div>

                <div class="form col-xs-12 col-md-5">

                    <div class="form-group">

                        <label for="ipt" class="col-xs-12 control-label col-md-4 text-left"> </label>
                        <div class="col-xs-12 col-md-8">
                            <?php if($row['id'] !=''): ?> Leave blank if you don't want to change current password <?php else: ?> Create Password <?php endif; ?>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ipt" class="col-xs-12 control-label col-md-4"> New Password </label>
                        <div class="col-xs-12 col-md-8">
                            <input name="password" type="password" id="password" class="form-control input-sm" value="" <?php if($row[ 'id']=='' ): ?> required <?php endif; ?> />
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="ipt" class="col-xs-12 control-label col-md-4"> New Password Confirmation </label>
                        <div class="col-xs-12 col-md-8">
                            <input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" <?php if($row[ 'id']=='' ): ?> required <?php endif; ?> />
                        </div>
                    </div>

                </div>


            </div>
            <div class="row">
                <div class="form-actions col-xs-12 col-md-7">
                    <hr>
                    <div class="col-md-offset-4 col-md-8">
                        <button type="submit" name="submit" class="btn green"><i class="fa  fa-save "></i> Save</button>
                        <button type="submit" name="apply" value="apply" class="btn blue"><i class="fa  fa-check-circle"></i> Apply Change(s)</button>
                        <button type="button" onclick="location.href='<?php echo e(url('user?return='.$return)); ?>' " class="btn btn-default "><i class="fa  fa-arrow-circle-left "></i> Cancel </button>
                    </div>
                </div>
            </div>
        </div>
        <?php echo Form::close(); ?>

    </div>
</div>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $("#group_id").jCombo("<?php echo e(url('user/comboselect?filter=tb_groups:group_id:name')); ?>", {
            selected_value: '<?php echo e($row["group_id"] ? $row["group_id"] : 1); ?>'
        });

    });
</script>
<?php $__env->stopSection(); ?> <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>