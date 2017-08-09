
<?php $__env->startSection('content'); ?>
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-link font-red"></i>
                        <span class="caption-subject font-red bold">Manage Menu</span>
                    </div>
                    <div class="actions">
                        
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
                                    <div class="col-sm-5">

					                    <div class="note note-info animated fadeIn">
					                        <p> Drag and Drop to reorder menu list</p>
					                    </div>

					                    <ul class="sortable-list" style="min-height:350px;">
				                            <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				                            <li data-id="<?php echo e($menu['menu_id']); ?>" class="sortable-item">
			                                	<?php echo e($menu['menu_name']); ?>

			                                    <span class="pull-right">
			                                        <a href="<?php echo e(URL::to('core/menu/'.$menu['menu_id'])); ?>"><i class="fa fa-edit"></i></a>
			                                    </span>
				                                <?php if(count($menu['childs']) > 0): ?>
				                                <ul class>
				                                    <?php $__currentLoopData = $menu['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				                                    <li data-id="<?php echo e($menu2['menu_id']); ?>" class="sortable-item">
				                                        <?php echo e($menu2['menu_name']); ?>

			                                            <span class="pull-right">
												           <a href="<?php echo e(URL::to('core/menu/'.$menu2['menu_id'])); ?>"><i class="fa fa-edit"></i></a>
			                                            </span>
				                                        <?php if(count($menu2['childs']) > 0): ?>
				                                        <ul class="" style="">
				                                            <?php $__currentLoopData = $menu2['childs']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
				                                            <li data-id="<?php echo e($menu3['menu_id']); ?>" class="dd-item dd3-item">
				                                                <?php echo e($menu3['menu_name']); ?>

				                                                <span class="pull-right">
																	<a href="<?php echo e(URL::to('core/menu/'.$menu3['menu_id'])); ?>"><i class="fa fa-edit"></i></a>
																</span>
				                                            </li>
				                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				                                        </ul>
				                                        <?php endif; ?>
				                                    </li>
				                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
				                                </ul>
				                                <?php else: ?>
				                                <ul></ul>
				                                <?php endif; ?>
				                            </li>
				                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                    </ul>
					                    <?php echo Form::open(array('url'=>'core/menu/reorder', 'class'=>'form-horizontal','files' => true,'id'=>'frm-reorder')); ?>

					                    <input type="hidden" name="reorder" id="reorder" value="" />
					                    <div class="infobox infobox-danger fade in">
					                       <p> Note!, Menus only support 2 levels </p>
					                    </div>

					                    <button type="submit" class="btn btn-sm red "> Reorder Menu </button>
					                    <?php echo Form::close(); ?>


					                </div>

					                <div class="col-sm-7">

					                    <?php echo Form::open(array('url'=>$action, 'class'=>'form-horizontal','files' => true,'data-parsley-validate'=>'')); ?>


					                    <div class="form-group  ">
					                        <label for="ipt" class=" control-label col-md-4 text-right"> </label>
					                        <div class="col-md-8">
					                            <h3>
													<?php if(@$row->menu_id ==''): ?>
														Create New Menu
													<?php else: ?>
														Edit Current Menu
													<?php endif; ?>
												</h3>

					                        </div>
					                    </div>
					                    <div class="form-group">
					                        <label for="ipt" class=" control-label col-md-4 text-right">Name / Title</label>
					                        <div class="col-md-8">
					                        	<input type="text" name="menu_name" value="<?php echo e(@$row->menu_name); ?>" class="form-control" required>
					                        </div>
					                    </div>

					                    <div class="form-group">
					                        <label for="ipt" class="col-md-4 text-right">Menu Type</label>
					                        <div class="col-md-8 menutype">
					                            <label class="icheck">
					                                <input type="radio" name="menu_type" value="internal" class="" <?php if(@$row->menu_type=='internal' || @$row->menu_type=='' ): ?> checked="checked" <?php endif; ?> /> Internal
					                            </label> 
					                            <label class="icheck">
					                                <input type="radio" name="menu_type" value="external" class="" <?php if(@$row->menu_type=='external' ): ?> checked="checked" <?php endif; ?> /> External
					                            </label>
					                        </div>
					                    </div>

					                    <div class="form-group ext-link" style="display: none;">
					                        <label for="ipt" class=" control-label col-md-4 text-right"> Url </label>
					                        <div class="col-md-8">
					                            <?php echo Form::text('url', @$row->url,array('class'=>'form-control', 'placeholder'=>' Type External Url')); ?>

					                        </div>
					                    </div>

					                    <div class="form-group int-link">
					                        <label for="ipt" class=" control-label col-md-4 text-right"> Module </label>
					                        <div class="col-md-8">
					                            <select name='module' rows='5' id='module' class='form-control'>

					                                <option value=""> -- Select Model -- </option>
					                                <option value=""> Sub-Menus Group </option>
					                                <option value="separator" <?php if(@$row->module=='separator' ): ?> selected="selected" <?php endif; ?>> Separator Menu </option>
					                                <optgroup label="Module ">
					                                    <?php $__currentLoopData = $modules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					                                        <option value="<?php echo e($mod->module_name); ?>" <?php if(@$row->module==$mod->module_name ): ?> selected="selected" <?php endif; ?> ><?php echo e($mod->module_title); ?></option>
					                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					                                </optgroup>
					                            </select>
					                        </div>
					                    </div>

					                    <div class="form-group  ">
					                        <label for="ipt" class="control-label col-md-4 text-right">Icon Class</label>
					                        <div class="col-md-8">
					                        	<input type="text" name="menu_icons" value="<?php echo e(@$row->menu_icons); ?>" class="form-control"><br>
					                            <p> Example : <span class="label label-danger"> icon-windows8 </span> , <span class="label label-danger"> fa fa-cloud-upload </span> </p>
					                            <p> Useage
					                                <a href="http://fontawesome.io/icons" target="_blank"> Font Awesome </a> class name</p>
					                        </div>
					                    </div>
					                    <div class="form-group  ">
					                        <label for="ipt" class="col-md-4 text-right"> Active </label>
					                        <div class="col-md-8">
					                            <label class="icheck">
					                                <input type="radio" name="active" value="1" <?php if(@$row->active=='1' ): ?> checked="checked" <?php endif; ?> /> Active
					                            </label>
					                            <label class="icheck">
					                                <input type="radio" name="active" value="0" <?php if(@$row->active=='0' ): ?> checked="checked" <?php endif; ?> /> Inactive
					                            </label>

					                        </div>
					                    </div>

					                    <div class="form-group">
					                        <label for="ipt" class=" control-label col-md-4">Access</label>
					                        <div class="col-md-8 margin-top-10">
					                        <?php 
												$pers = json_decode(@$row->access_data,true);
												foreach($groups as $group) {
													$checked = '';
													if(isset($pers[$group->group_id]) && $pers[$group->group_id]=='1')
													{
														$checked= ' checked="checked"';
													}						
														?>
					                                <label class="checkbox checkbox-inline icheck">
					                                    <input type="checkbox" name="groups[<?php echo $group->group_id;?>]" value="<?php echo $group->group_id;?>" <?php echo $checked;?> />
					                                    <?php echo $group->name;?>
					                                </label>

					                                <?php } ?>
					                        </div>
					                    </div>

					                    <div class="form-group">
					                        <label class="col-sm-4 text-right">&nbsp;</label>
					                        <div class="col-sm-8">
					                            <?php if(@$row->menu_id !=''): ?>
					                            <button type="submit" class="btn btn-success ">Save change(s)</button>
					                            <a href="<?php echo e(url('core/menu/'.$row->menu_id.'/delete')); ?>" onclick="return confirm('Are you sure want to delete?');" class="btn btn-danger "> Delete </a>
					                            <?php else: ?>
					                            <button type="submit" class="btn btn-success ">Submit</button>
					                            <?php endif; ?>
					                            <a href="<?php echo e(url('core/menu')); ?>" class="btn btn-default ">Cancel</a>
					                        </div>

					                    </div>

					                </div>

					                <?php echo Form::close(); ?>

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
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery-sortable-min.js')); ?>" type="text/javascript" ></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$('input[name="menu_type"]').on('ifChecked', function(event){
			var menuType = $(this).val();
			if(menuType == 'external') {
				$('.ext-link').show();
				$('.int-link').hide();
			}else{
				$('.ext-link').hide();
				$('.int-link').show();
			}
		});
		$('#frm-reorder').click(function() {
            var data = $('.sortable-list').sortable("serialize").get();
            var jsonString = JSON.stringify(data, null, '\t');
            $('#reorder').val(jsonString);
            $('#frm-reorder').submit();
        });

        var oldContainer;
        $('.sortable-list').sortable({
            group: 'nested'
        });
	});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.system', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>