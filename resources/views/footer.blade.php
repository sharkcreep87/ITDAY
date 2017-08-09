<div class="table-footer">
    <div class="row">
        <div class="form col-xs-12 col-sm-10 col-md-8">
            <div class="table-actions" style=" padding: 10px 0">

                {!! Form::open(array('url'=>'admin/'.$pageModule.'/filter/','class' => 'form-inline')) !!}
                <?php $pages = array(5,10,20,30,50) ?>
                    <?php $orders = array('asc','desc') ?>
                        <div class="form-group col-xs-6 col-sm-2">
                            <select name="rows" data-placeholder="Show" class="form-control" style="width: 100%;">
                                <option value=""> Page </option>
                                @foreach($pages as $p)
                                <option value="{!! $p !!}" @if(isset($pager[ 'rows']) && $pager[ 'rows']==$p) selected="selected" @endif>{!! $p !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-4">
                            <select name="sort" data-placeholder="Sort" class="form-control" style="width: 100%;">
                                <option value=""> Sort </option>
                                @foreach($tableGrid as $field) @if($field['view'] =='1' && $field['sortable'] =='1')
                                <option value="{!! $field['field'] !!}" @if(isset($pager[ 'sort']) && $pager[ 'sort']==$field[ 'field']) selected="selected" @endif>{!! $field['label'] !!}</option>
                                @endif 
                                @endforeach

                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-3">
                            <select name="order" data-placeholder="Order" class="form-control" style="width: 100%;">
                                <option value=""> Order</option>
                                @foreach($orders as $o)
                                <option value="{!! $o !!}" @if(isset($pager[ 'order']) && $pager[ 'order']==$o) selected="selected" @endif>{!! ucwords($o) !!}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-xs-6 col-sm-3">
                            <button type="submit" class="btn green"><i class="fa fa-arrow-circle-o-right"></i> GO</button>
                            <input type="hidden" name="md" value="{!! (isset($masterdetail['filtermd']) ? $masterdetail['filtermd'] : '') !!}" />
                            <input type="hidden" name="sc" value="{!! @$_GET['search'] !!}" />
                        </div>
                        {!! Form::close() !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-2 col-md-4">
            <p class="text-center bold" style=" padding: 25px 0">
                Total : <b>{!! $pagination->total() !!}</b>
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            {!! $pagination->appends($pager)->render() !!}
        </div>
    </div>
</div>