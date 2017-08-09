
<?php $__env->startSection('table'); ?>
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong><?php echo e($row->module_title); ?> Table</strong> ( Change table settings of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="<?php echo e(url('core/model/config/'.$row->module_id.'/table')); ?>" method="post" class="form-vertical" data-parsley-validate>
            <?php echo e(csrf_field()); ?>

            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="table">
                    <thead class="no-border">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Field</th>
                            <th scope="col" width="80"><i class="fa fa-key"></i> Limit</th>
                            <th scope="col"><i class="icon-link"></i></th>
                            <th scope="col" data-hide="phone">Title / Caption </th>
                            <th scope="col" width="75" data-hide="phone">Align</th>
                            <th scope="col" width="75" data-hide="phone">Width</th>
                            <th scope="col" data-hide="phone">Show</th>
                            <th scope="col" data-hide="phone">View </th>
                            <th scope="col" data-hide="phone">Sortable</th>
                            <th scope="col" data-hide="phone">Download</th>
                            <th scope="col" data-hide="phone">API</th>
                            <th scope="col" data-hide="phone" width="200px"> Format As </th>
                        </tr>
                    </thead>
                    <tbody class="no-border-x no-border-y">
                        <?php 
                            usort($config['grid'], "SiteHelpers::_sort"); 
                            $num=0;
                        ?>
                        <?php $__currentLoopData = $config['grid']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rows): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $id = ++$num; ?>
                            <tr>
                                <td class="index">
                                    <?php echo e($id); ?>

                                </td>
                                <td>
                                    <strong><?php echo e($rows['field']); ?></strong>
                                    <input type="hidden" name="field[<?php echo e($id); ?>]" id="field" value="<?php echo e($rows['alias']); ?>" /> 
                                </td>
                                <td>
                                    <?php
                                         $limited_to = (isset($rows['limited']) ? $rows['limited'] : '');
                                    ?>
                                    <input type="text" class="form-control input-sm" name="limited[<?php echo e($id); ?>]" class="limited" value="<?php echo e($limited_to); ?>" />

                                </td>
                                <td>
                                    <a href="javascript:;" class="<?php if(isset($rows['conn']['valid']) && $rows['conn']['valid'] == '1'): ?> font-red <?php else: ?> font-blue <?php endif; ?> " title="Lookup Display" onclick="_Modal('<?php echo e(url('core/model/config/'.$row->module_id.'/conn?table_field='.$rows['field'].'&table_alias='.$rows['alias'])); ?>' ,' Connect Field : <?php echo e($rows['field']); ?> ' )">
                                        <i class="fa fa-external-link"></i>
                                    </a>
                                </td>
                                <td>
                                    <input name="label[<?php echo e($id); ?>]" type="text" class="form-control input-sm" id="label" value="<?php echo e($rows['label']); ?>" />
                                </td>
                                <td>
                                    <input name="align[<?php echo e($id); ?>]" type="text" class="form-control input-sm" id="align" value="<?php echo e($rows['align']); ?>" />
                                </td>
                                <td>
                                    <input name="width[<?php echo e($id); ?>]" type="text" class="form-control input-sm" id="width" value="<?php echo e($rows['width']); ?>" />
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="view[<?php echo e($id); ?>]" type="checkbox" id="view" value="1" <?php if($rows[ 'view']==1 ): ?> checked <?php endif; ?>/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="detail[<?php echo e($id); ?>]" type="checkbox" id="detail" value="1" <?php if($rows[ 'detail']==1 ): ?> checked <?php endif; ?>/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="sortable[<?php echo e($id); ?>]" type="checkbox" id="sortable" value="1" <?php if($rows['sortable']==1): ?> checked <?php endif; ?> />
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="download[<?php echo e($id); ?>]" type="checkbox" id="download" value="1" <?php if($rows['download']==1 ): ?> checked <?php endif; ?>/>
                                    </label>
                                </td>
                                <td>
                                    <label class="icheck">
                                        <input name="api[<?php echo e($id); ?>]" type="checkbox" id="api" value="1" <?php if($rows[ 'api']==1): ?> checked <?php endif; ?> />
                                    </label>
                                </td>
                                <td>
                                    <select class="form-control input-sm" name="format_as[<?php echo e($id); ?>]">
                                        <option value=''> None </option>
                                        <?php $__currentLoopData = $formats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($key); ?>" <?php if(isset($rows[ 'format_as']) && $rows[ 'format_as']==$key): ?> selected <?php endif; ?> > <?php echo e($val); ?> </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <div class="input-group margin-top-5">
                                        <input type="text" name="format_value[<?php echo e($id); ?>]" value="<?php if(isset($rows['format_value'])): ?><?php echo e($rows['format_value']); ?><?php endif; ?>" class="form-control input-sm" placeholder="Format Value"> 
                                        <a href="javascript://ajax" data-html="true" class="text-success format_info" data-toggle="popover" title="Example Usage" data-content="  <b>Data </b> = dd-yy-mm <br /> <b>Image</b> = /uploads/path_to_upload <br />  <b>Link </b> = http://domain.com ? <br /> <b> Function </b> = class|method|params <br /> <b>Checkbox</b> = value:Display,...<br /> <b>Limit String</b> = 255<br /><b>Number Format</b> = 2<br /> <b>Database</b> = table|id|field <br /><br /> All Field are accepted using tag {FieldName} . Example {<b><?php echo e($rows['field']); ?></b>} " data-placement="left">
                                        <i class="icon-question4"></i> Help? </a>                                     
                                    </div>
                                    <input type="hidden" name="frozen[<?php echo e($id); ?>]" value="<?php echo e($rows['frozen']); ?>" />
                                    <input type="hidden" name="search[<?php echo e($id); ?>]" value="<?php echo e($rows['search']); ?>" />
                                    <input type="hidden" name="hidden[<?php echo e($id); ?>]" value="<?php if(isset($rows['hidden'])): ?><?php echo e($rows['hidden']); ?><?php endif; ?>" />
                                    <input type="hidden" name="alias[<?php echo e($id); ?>]" value="<?php echo e($rows['alias']); ?>" />
                                    <input type="hidden" name="field[<?php echo e($id); ?>]" value="<?php echo e($rows['field']); ?>" />
                                    <input type="hidden" name="sortlist[<?php echo e($id); ?>]" class="reorder" value="<?php echo e($rows['sortlist']); ?>" />
                                    <input type="hidden" name="conn_valid[<?php echo e($id); ?>]" value="<?php if(isset($rows['conn']['valid'])): ?><?php echo e($rows['conn']['valid']); ?><?php endif; ?>" />
                                    <input type="hidden" name="conn_db[<?php echo e($id); ?>]" value="<?php if(isset($rows['conn']['db'])): ?><?php echo e($rows['conn']['db']); ?><?php endif; ?>" />
                                    <input type="hidden" name="conn_key[<?php echo e($id); ?>]" value="<?php if(isset($rows['conn']['key'])): ?><?php echo e($rows['conn']['key']); ?><?php endif; ?>" />
                                    <input type="hidden" name="conn_display[<?php echo e($id); ?>]" value="<?php if(isset($rows['conn']['display'])): ?><?php echo e($rows['conn']['display']); ?><?php endif; ?>" />
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="note note-info">
                <p> <strong>Tips !</strong> Drag and drop rows to re ordering lists </p>
            </div>
            <button type="submit" class="btn green"> Save Changes </button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('plugin'); ?>
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')); ?>" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<script type="text/javascript">
    $(document).ready(function() {

        $('.format_info').popover()

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function(i) {
                    $(this).html(i + 1);
                });
                $('.reorder', ui.item.parent()).each(function(i) {
                    $(this).val(i + 1);
                });
            };

        $("#table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('core.model.config', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>