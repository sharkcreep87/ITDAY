
<?php $__env->startSection('style'); ?>
<link href="<?php echo e(asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('index'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> List</strong> ( List all of <?php echo e($row->module_title); ?> Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_get">
                <h3>List all <?php echo e($row->module_title); ?></h3>
                <p>Manage your API as default rows limit, sorting by, filter with default value.</p>
                <?php echo Form::open(array('url'=>'core/graph/'.$row->module_id.'/index', 'class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')); ?> 
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Field </th>
                                    <th> Type </th>
                                    <th> Show </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$col): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td> <?php echo e($key + 1); ?> </td>
                                    <td> <?php echo e($col['Field']); ?> <?php if($col['Key'] == 'PRI'): ?> (<?php echo e($col['Key']); ?>) <?php endif; ?></td>
                                    <td> <?php echo e($col['Type']); ?> </td>
                                    <td class="icheck">
                                        <input type="checkbox" name="api[<?php echo e($key); ?>]" <?php if($grid[$key]['api'] == 1): ?> checked <?php endif; ?> /> </td>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <h4>Request Parameter</h4>
                    
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> Param Name </th>
                                    <th> Value </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Page </td>
                                    <td> 
                                        <input type="text" name="page" value="<?php if(isset($request['page'])): ?><?php echo e($request['page']); ?><?php else: ?><?php echo e(1); ?><?php endif; ?>" class="form-control input-sm" parsley-type="number" required> 
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Rows </td>
                                    <td> 
                                        <input type="text" name="rows" value="<?php if(isset($request['rows'])): ?><?php echo e($request['rows']); ?><?php else: ?><?php echo e(10); ?><?php endif; ?>" class="form-control input-sm" parsley-type="number" required> 
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Sort </td>
                                    <td> 
                                        <select name="sort" class="form-control select2">
                                            <?php $__currentLoopData = $grid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$grd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($grd['sortable'] == 1): ?>
                                                <option value="<?php echo e($grd['field']); ?>" <?php if(isset($request['sort']) && $request['sort'] == $grd['field']): ?> selected <?php endif; ?>><?php echo e($grd['field']); ?></option>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </td>
                                    <td>
                                        Default
                                    </td>`
                                </tr>
                                <tr>
                                    <td> Order </td>
                                    <td> 
                                        <select name="order" class="form-control select2">
                                            <option value="asc" <?php if(isset($request['order']) && $request['order'] == 'asc'): ?> selected <?php endif; ?>>asc</option>
                                            <option value="desc" <?php if(isset($request['order']) && $request['order'] == 'desc'): ?> selected <?php endif; ?>>desc</option>
                                        </select>
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Search </td>
                                    <td> 
                                        <input type="text" name="search" value="<?php if(isset($request['search'])): ?><?php echo e($request['search']); ?><?php endif; ?>" id="search" class="form-control input-sm"> 
                                    </td>
                                    <td>
                                        <a href="<?php echo e(url('core/graph/builder/'.$row->module_id.'/search')); ?>" class="btn btn-sm green" onclick="_Modal(this.href,'Search Builder'); return false;"><i class="fa fa-wrench"></i> Build</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="note note-danger">
                        <p>If you changed default parameter values, it will set default values in your API. </p>
                    </div>
                    <button type="submit" class="btn red-mint btn-outline sbold">Save changes</button>
                <?php echo Form::close(); ?>

            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">GET <i class="fa fa-long-arrow-right tips" data-original-title="<?php echo e(url('/')); ?>"></i> /api/<?php echo e(strtolower($row->module_name)); ?></h4>
                    </div>
                    <div class="panel-body">
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code>  <a href="<?php echo e(url('core/graph/token')); ?>" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Request Param:</h4>
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/<?php echo e(strtolower($row->module_name)); ?>"></i> 
                        <code id="request-param">?page=<?php if(isset($request['page'])): ?><?php echo e($request['page']); ?><?php else: ?><?php echo e(1); ?><?php endif; ?>&rows=<?php if(isset($request['rows'])): ?><?php echo e($request['rows']); ?><?php else: ?><?php echo e(10); ?><?php endif; ?>&sort=<?php if(isset($request['sort'])): ?><?php echo e($request['sort']); ?><?php else: ?><?php echo e('id'); ?><?php endif; ?>&order=<?php if(isset($request['order'])): ?><?php echo e($request['order']); ?><?php else: ?><?php echo e('asc'); ?><?php endif; ?>&search=<?php if(isset($request['search'])): ?><?php echo e($request['search']); ?><?php endif; ?></code>
                        <h4>Response Body:<small id="_get-status" class="bold"></small></h4>
                        <div class="well response" id="_get-response" style="font-size: 12px;"></div>
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
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
	$(document).ready(function () {
		$('#_get-response').css({"height": ($('#_get').height() - 150)+'px' });

        $.ajax({
            url: '<?php echo e(url("api/".strtolower($row->module_name))); ?>'+$('#request-param').html().replace(/&amp;/g,"&"),
            type: 'GET',
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer <?php echo e($access_token); ?>'
            },
            contentType: 'application/json; charset=utf-8',
            success: function ($result) {
                $('#_get-status').html('<span class="font-green">status[200]</span>');
                $('#_get-response').jsonView($result);
            },
            error: function ($error) {
                $('#_get-status').html(mFail($error));
                $('#_get-response').jsonView($error.responseJSON);
            }
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