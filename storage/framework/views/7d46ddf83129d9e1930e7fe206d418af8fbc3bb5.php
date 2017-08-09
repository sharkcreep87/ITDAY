
<?php $__env->startSection('style'); ?>
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('update'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>Update <?php echo e($row->module_title); ?></strong> ( Change data of <?php echo e($row->module_title); ?> Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_update">
                <h3>Update a <?php echo e($row->module_title); ?></h3>
                <p>To update a <?php echo e($row->module_name); ?>, click on <code> <i class="fa fa-long-arrow-right"></i> /id</code> and change id <code>value</code> that you want to update an record.</p>
                <p>Change in following form parameter that you want, and click on <code>submit</code> button.</p>
                <h4>Header:</h4>
                <small>
                    <b>Accept: </b> <code>application/json</code><br>
                    <b>Authorization: </b> <code>Bearer {$access_token}</code>
                </small>
                <h4>Form Parameter</h4>
                <?php echo Form::open(array('url'=>url('api/'.strtolower($row->module_name)), 'id'=>'_update-form','class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')); ?> 
                <?php echo e(method_field('PUT')); ?>

                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Field </th>
                                <th> Type </th>
                                <th> Value </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php 
                                $col = $columns[array_search($f['field'], array_column($columns, 'Field'))]; 
                            ?>
                            <?php if($col['Key'] != 'PRI' && $f['view'] == 1 && $f['type'] != 'hidden'): ?>
                            <tr>
                                <td> <?php echo e($i); ?> </td>
                                <td> <?php echo e($col['Field']); ?> </td>
                                <td width="100px;"> <?php echo e($col['Type']); ?> </td>
                                <td width="250px;">
                                    <?php echo SiteHelpers::transForm($col['Field'] , $forms, false, '', 'input-sm '.$col['Field']); ?>

                                </td>
                            </tr>
                            <?php $i++; ?>
                            <?php endif; ?>

                            <!-- Input Group -->
                            <?php if(isset($f['input_group']) && count($f['input_group']) > 0): ?>
                                <?php $__currentLoopData = $f['input_group']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $input_f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $col = $columns[array_search($input_f['field'], array_column($columns, 'Field'))]; 
                                    ?>
                                    <?php if($col['Key'] != 'PRI' && $input_f['view'] == 1 && $input_f['type'] != 'hidden'): ?>
                                    <tr>
                                        <td> <?php echo e($i); ?> </td>
                                        <td> <?php echo e($col['Field']); ?> </td>
                                        <td width="100px;"> <?php echo e($col['Type']); ?> </td>
                                        <td width="250px;">
                                            <?php echo SiteHelpers::transForm($col['Field'] , $f['input_group'], false, '', 'input-sm '.$col['Field']); ?>

                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn red-mint btn-outline sbold">Submit</button>
                <?php echo Form::close(); ?>

            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PUT <i class="fa fa-long-arrow-right tips font-lowercase" data-original-title="<?php echo e(url('/')); ?>"></i> /api/<?php echo e(strtolower($row->module_name)); ?>/{id}</h4>
                    </div>
                    <div class="panel-body">
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/<?php echo e(strtolower($row->module_name)); ?>/{id}"></i> 
                        <code id="url-param"> / <a href="javascript:;" id="update-id" data-type="text" data-pk="1" data-original-title="Enter id value"> id </a></code>
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code> <a href="<?php echo e(url('core/graph/token')); ?>" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Response Body:<small id="_update-status" class="bold"></small></h4>
                        <div class="well response" id="_update-response" style="font-size: 12px;"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#update-id").editable( {
            type: "number", 
            pk: 1, 
            name: "id", 
            title: "Enter id value",
            success: function(response, newValue) {
                $('#_update-response').html('');
                $.ajax({
                    url: '<?php echo e(url("api/".strtolower($row->module_name))); ?>/'+newValue,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': '<?php echo e($access_token); ?>'
                    },
                    contentType: 'application/json; charset=utf-8',
                    success: function ($response) {
                        $('#_update-status').html('<i class="font-green">status[200]</i>');
                        $('#_update-response').jsonView($response);
                        $('select.select2').select2('destroy');
                        <?php $__currentLoopData = $forms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($f['type'] == 'file'): ?>
                                $("#_update-form tbody").append('<input type="hidden" name="<?php echo e($f['field']); ?>" value="'+$response.<?php echo e($f['field']); ?>+'" />');
                            <?php else: ?>
                                $(".<?php echo e($f['field']); ?>").val($response.<?php echo e($f['field']); ?>);
                            <?php endif; ?>
                            <?php if(isset($f['input_group']) && count($f['input_group']) > 0): ?>
                                <?php $__currentLoopData = $f['input_group']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($f['type'] == 'file'): ?>
                                        $("#_update-form tbody").append('<input type="hidden" name="<?php echo e($f['field']); ?>" value="'+$response.<?php echo e($f['field']); ?>+'" />');
                                    <?php else: ?>
                                        $(".<?php echo e($f['field']); ?>").val($response.<?php echo e($f['field']); ?>);
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        $('.select2').select2();
                    },
                    error: function ($error) {
                        $('#_update-status').html(mFail($error));
                        $('#_update-response').jsonView($error.responseJSON);
                    }
                });
            },
        });

        $('#_update-response').css({"height": ($('#_update').height())+'px' });
        $('#_update-form').submit(function(e) {
            $('#_update-response').html('');
            $.ajax({
                url: '<?php echo e(url("api/".strtolower($row->module_name))); ?>/'+$('#update-id').html(),
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer <?php echo e($access_token); ?>'
                }
            }).done(function($response) {
                $('#_update-status').html('<span class="font-green">status[200]</span>');
                $('#_update-response').jsonView($response);
            }).fail(function($error){
                $('#_update-status').html(mFail($error));
                $('#_update-response').jsonView($error.responseJSON);
            });
            e.preventDefault();
        });

        var mFail = function($error){
            if($error.status == 400)
            {
                return '<span class="font-yellow-gold">status['+ $error.status+']</span>';
            }else
            {
                return '<span class="font-red">status['+ $error.status+']</span>';
            }
            return '';
        }
	})
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('core.graph.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>