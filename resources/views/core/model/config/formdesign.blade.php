@extends('core.model.config')
@section('formdesign')
<form action="{{url('core/model/config/'.$row->module_id.'/formdesign')}}" method="post" class="form-vertical" id="doReorder" data-parsley-validate>
    {{csrf_field()}}
    <div class="col-md-4">
        <div class="form-group ">
            <label> Number Of Block : </label>
            <select class="form-control" required name="column" style="width:200px;" onchange="location.href='?block='+this.value">
                <?php for($i=1 ; $i<5;$i++) {?>
                    <option value="<?php echo $i;?>" <?php if($form_column==$i) echo 'selected';?> >
                        <?php echo $i;?> Block </option>
                    <?php  } ?>
            </select>

        </div>
        @if($form_column == 2)
        <div class="form-group ">
            <label> Columns Width : </label>
            <select class="form-control" required name="width" style="width:200px;" onchange="location.href='?block={{$form_column}}&width='+this.value">
                <option value="6^6" <?php if($form_width=='6^6') echo 'selected';?>>6/6 Columns</option>
                <option value="8^4" <?php if($form_width=='8^4') echo 'selected';?>>8/4 Columns</option>
                <option value="4^8" <?php if($form_width=='4^8') echo 'selected';?>>4/8 Columns</option>
            </select>

        </div>
        @endif
    </div>
    <div class="form-vertical">
        <div class="col-md-4">
            <div class="form-group">
                <label> Display Form As : </label>
                <div class="radio-group icheck">
                    <input type="radio" name="format" value="grid" <?php if(@$config['form_layout']['format']=='grid' ) echo 'checked';?> /> Grid
                    <input type="radio" name="format" value="tab" <?php if(@$config['form_layout']['format']=='tab' ) echo 'checked';?> /> Tab
                </div>
            </div>

            <div class="form-group">
                <label> Form Layout : </label>
                <div class="radio-group icheck">

                    <input type="radio" name="display" value="horizontal" <?php if(@$config['form_layout']['display']=='horizontal' ) echo 'checked';?> /> Normal

                    <input type="radio" name="display" value="vertical" <?php if(@$config['form_layout']['display']=='vertical' ) echo 'checked';?> /> Vertical

                </div>
            </div>

        </div>
        
    </div>
    <div class="margin-bottom-20" style="clear:both; border-bottom:dashed 1px #ddd; padding:5px;"></div>
    <!-- BEGIN: XHTML for example 1.2 -->
    <div id="FormLayout" class="row">
        <?php

            for($i=0;$i<$form_column;$i++)
            {
                if($form_column == 4) {
                    $class = 'col-md-3';
                }  elseif( $form_column ==3 ) {
                    $class = 'col-md-4';
                }  elseif( $form_column ==2 ) {
                    $width = explode('^', $form_width);
                    $class = 'col-md-'.$width[$i];
                } else {
                    $class = 'col-md-12';
                }
                ?>
                <div class="column left  <?php echo $class ;?>">
                    <div class="form-group">
                        <label for="ipt" class=" "> Block Title
                            <?php echo $i+1;;?>
                        </label>
                        <input type="type" name="title[]" class="form-control" required placeholder=" Title Block " value="<?php if(isset($title[$i])) echo $title[$i];?>" />
                    </div>

                    <ul class="sortable-list">
                    <?php foreach($config['forms'] as $rows){
                        if($rows['form_group'] == $i) {
                            $input_group = '';
                            if(isset($rows['input_group'])){
                                foreach ($rows['input_group'] as $input) {
                                    $input_group .= '<li class="sortable-item" data-val="'.SiteHelpers::CF_encode_json($input).'" data-id="'.$input['field'].'"> '.$input['label'].'<ul class></ul> </li>';
                                }
                            }
                            echo '<li class="sortable-item" data-val="'.SiteHelpers::CF_encode_json($rows).'" data-id="'.$rows['field'].'" > '.$rows['label'].'<ul class>'.$input_group.'</ul> </li>';
                        }
                    }?>
                    </ul>
                </div>
                <?php
            }

        ?>

        <div class="clearer">&nbsp;</div>
        <div class="col-md-12" style="margin:10px 0;">

        </div>

    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <input type="hidden" name="reordering" id="reordering" value="" class="form-control" />
                <input type="hidden" name="module_id" value="{{ $row->module_id }}" />
                <button type="button" class="btn green" id="saveLayout"> Save Layout </button>

            </div>
        </div>
    </div>
</form>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/jquery-sortable-min.js') }}" type="text/javascript" ></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function () {
		$('#saveLayout').click(function() {
            var data = $('#FormLayout .sortable-list').sortable("serialize").get();
            var jsonString = JSON.stringify(data, null, '\t');
            $('#reordering').val(jsonString);
            $('#doReorder').submit();
        });

        var oldContainer;
        $('#FormLayout .sortable-list').sortable({
            group: 'nested'
        });
	});
</script>
@endsection