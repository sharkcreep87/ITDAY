
<?php $__env->startSection('style'); ?>
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css')); ?>" rel="stylesheet" type="text/css" />
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('destroy'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>Destroy <?php echo e($row->module_title); ?></strong> ( Delete data of <?php echo e($row->module_title); ?> Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_delete">
                <h3>Delete a <?php echo e($row->module_title); ?></h3>
                <p>To delete a <?php echo e($row->module_name); ?>, click on <code> <i class="fa fa-long-arrow-right"></i> /id</code> and change id <code>value</code> that you want to delete an record.</p>
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">DELETE <i class="fa fa-long-arrow-right tips" data-original-title="<?php echo e(url('/')); ?>"></i> /api/<?php echo e(strtolower($row->module_name)); ?>/{id}</h4>
                    </div>
                    <div class="panel-body">
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/<?php echo e(strtolower($row->module_name)); ?>/{id}"></i> 
                        <code id="url-param"> / <a href="javascript:;" id="_delete-id" data-type="text" data-pk="1" data-original-title="Enter id value"> id </a></code>
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code> <a href="<?php echo e(url('core/graph/token')); ?>" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Response Body:<small id="_delete-status" class="bold"></small></h4>
                        <div class="well response" id="_delete-response" style="font-size: 12px;"></div>
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
		$('#_delete-response').css({"height": ($('#_delete').height())+'px' });
		$("#_delete-id").editable( {
            type: "number", 
            pk: 1, 
            name: "id", 
            title: "Enter id value",
            success: function(response, newValue) {
                $('#_delete-response').html('');
                $.ajax({
                    url: '<?php echo e(url("api/".strtolower($row->module_name))); ?>/'+newValue,
                    type: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer <?php echo e($access_token); ?>'
                    },
                }).done(function($response) {
                    $('#_delete-status').html('<span class="font-green">status[200]</span>');
                    $('#_delete-response').jsonView($response);
                }).fail(function($error){
                    $('#_delete-status').html(mFail($error));
                    $('#_delete-response').jsonView($error.responseJSON);
                });
            },
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