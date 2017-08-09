<div class="table-footer">
    <div class="row">
        <div class="form col-xs-12 col-sm-10 col-md-8">
            <div class="table-actions" style=" padding: 10px 0">

                <?php echo Form::open(array('url'=>'admin/'.$pageModule.'/filter/','class' => 'form-inline')); ?>

                <?php $pages = array(5,10,20,30,50) ?>
                    <?php $orders = array('asc','desc') ?>
                        <div class="form-group col-xs-6 col-sm-2">
                            <select name="rows" data-placeholder="Show" class="form-control" style="width: 100%;">
                                <option value=""> Page </option>
                                <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo $p; ?>" <?php if(isset($pager[ 'rows']) && $pager[ 'rows']==$p): ?> selected="selected" <?php endif; ?>><?php echo $p; ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            <select name="sort" data-placeholder="Sort" class="form-control" style="width: 100%;">
                                <option value=""> Sort </option>
                                <?php $__currentLoopData = $tableGrid; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php if($field['view'] =='1' && $field['sortable'] =='1'): ?>
                                <option value="<?php echo $field['field']; ?>" <?php if(isset($pager[ 'sort']) && $pager[ 'sort']==$field[ 'field']): ?> selected="selected" <?php endif; ?>><?php echo $field['label']; ?></option>
                                <?php endif; ?> 
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-3">
                            <select name="order" data-placeholder="Order" class="form-control" style="width: 100%;">
                                <option value=""> Order</option>
                                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $o): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo $o; ?>" <?php if(isset($pager[ 'order']) && $pager[ 'order']==$o): ?> selected="selected" <?php endif; ?>><?php echo ucwords($o); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-3">
                            <button type="submit" class="btn green"><i class="fa fa-arrow-circle-o-right"></i> GO</button>
                            <input type="hidden" name="md" value="<?php echo (isset($masterdetail['filtermd']) ? $masterdetail['filtermd'] : ''); ?>" />
                            <input type="hidden" name="sc" value="<?php echo @$_GET['search']; ?>" />
                        </div>
                        <?php echo Form::close(); ?>

            </div>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-4">
            <p class="text-center bold" style=" padding: 25px 0">
                Total : <b><?php echo $pagination->total(); ?></b>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <?php echo $pagination->appends($pager)->render(); ?>

        </div>
    </div>
</div>