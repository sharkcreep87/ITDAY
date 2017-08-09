<form action="{{url('core/model/config/'.$row->module_id.'/field')}}" method="post" class="form-horizontal" id="_field">
	{{csrf_field()}}
	<input type="hidden" name="alias" value="{{$field['alias']}}" />
	<input type="hidden" name="field" value="{{$field['field']}}" />	
	<div class="">

		<div class="form-group">
			<label for="ipt" class=" text-right col-md-4">Form Type </label>
			<div class="col-md-8">
				<select name="type" id="type" onchange="responeFormType(this.value)" class="form-control select2">
				@foreach($field_type_opt as $val=>$item)
					<option value="{{$val}}" @if($val == $field['type']) selected @endif>{{$item}}</option>
				@endforeach 
				</select>
			  
			</div> 
		</div>  
	  
		<div class="form-group standart-form"  style="display:none;">
			<label for="ipt" class=" text-right col-md-4">Data Type </label>
			<div class="col-md-8 datatype">
				<div class="checkbox icheck"> 
					<label class="cstvalue" >
						<input type="radio" name="opt_type"
						@if($field['option']['opt_type'] =='datalist') checked @endif
						class="dataOpt" value="datalist"/> Custom Value  
					</label>	
					<label class="dbasevalue">
						<input type="radio" name="opt_type"
						@if($field['option']['opt_type'] =='external') checked @endif
						class="dataOpt"  value="external"/> Database
					</label>	
				</div>
			  
			</div> 
		</div>    

		<div class="form-group standart-form datalist"  style="display:none;">
		    <label for="ipt" class=" text-right col-md-4">Custom Value </label>
			<div class="col-md-8 ">
				<div class="row">
				<?php $opt = explode("|",$field['option']['lookup_query']); ?>
				@if(count($opt) <= 0)
				<label class="clonedInput clone " >
					<div class="col-sm-4">
					  <input type="text" name="custom_field_val[]" class="form-control input-sm col-xs-5 custom_field_val"  placeholder="Value"  />
					</div>  
					<div class="col-sm-4">
					 <input type="text" name="custom_field_display[]" class="form-control input-sm col-xs-5 custom_field_display" placeholder="Display Name" />
					</div> 			
				</label>
				@else
					@for($i=0; $i<count($opt);$i++) 
					<?php $row =  explode(":",$opt[$i]); ?>
					<div class="clonedInput clone" style="clear:both; margin-bottom:5px;">
					    <div class="col-sm-4">
					        <input type="text" name="custom_field_val[]" class="form-control col-xs-5 custom_field_val" style="width:100px;" placeholder="Value" value="@if(isset($row[0])) {{$row[0]}} @endif" />
					    </div>
					    <div class="col-sm-4">
					        <input type="text" name="custom_field_display[]" class="form-control col-xs-5 custom_field_display" style="width:100px;" placeholder="Display Name" value="@if(isset($row[1])) {{$row[1]}} @endif" />
					    </div>
					    <div class="col-sm-4">
					    	<a onclick="$(this).parent().fadeIn(function(){ $(this).parent().remove() }); return false" href="#" class="remove btn btn-danger"><i class="fa  fa-minus "></i></a>
					    	<a href="javascript:void(0);" class="addC btn btn-info" rel=".clone"><i class="fa  fa-plus "></i></a>
						</div>
					</div>		
					@endfor
				@endif
				
				</div>
			 </div> 
		</div>    

		<div class="form-group standart-form database" style="display:none;">
		    <label for="ipt" class=" text-right col-md-4">Database Select</label>
			<div class="col-md-8">
				<div class="form-group">
					<div class="col-md-12">
						<select name="lookup_table" id="lookup_table"  class="ext form-control" style="width:100%;">
							<option value=""> -- Select Table -- </option>
							@foreach($tables as $row) 
							<option value="{{$row}}" @if($row == $field['option']['lookup_table']) selected @endif>{{$row}}</option>		 @endforeach
						</select>
					</div>
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<select name="lookup_key" id="lookup_key"  class="ext form-control"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="text-right col-md-4 display">Display #1 : </label>
					<div class="col-md-8">
						<select name="lookup_value[]"  class="ext form-control" id="lookup_value1"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="text-right col-md-4 display">Display #2 : </label>
					<div class="col-md-8">
						<select name="lookup_value[]"  class="ext form-control" id="lookup_value2"></select>
					</div>
				</div>
				<div class="form-group">
					<label class="text-right col-md-4 display">Display #3 : </label>
					<div class="col-md-8">
						<select name="lookup_value[]"  class="ext form-control" id="lookup_value3"></select>
					</div>
				</div>
				<div class="form-group parent-filter">
					<div class="col-md-12">
						<label class="checkbox icheck">
							<input type="checkbox" name="is_dependency" class="ext" value="1" @if($field['option']['is_dependency'] ==1) checked @endif /> Parent Filter
						</label>
					</div>				
				</div>
				<div class="form-group">
					<div class="col-md-12">
						<input name="lookup_dependency_key" type="text" class="ext form-control" id="lookup_key" value="{{$field['option']['lookup_dependency_key']}}" placeholder='Lookup Filter Key' />
					</div>
				</div>
				<div class="form-group allow-multi">
					<div class="col-md-12">
						<label class="checkbox icheck" >
							<input type="checkbox" name="select_multiple"  value="1" @if(isset($field['option']['select_multiple']) && $field['option']['select_multiple'] =='1') checked="checked" @endif  /> Allow Multiple
						</label>
					</div>
				</div>			
		 
			 </div> 
		</div>  

		<div class="form-group standart-form file-upl"  style="display:none;">
		    <label for="ipt" class=" text-right col-md-4"> File Path</label>
			<div class="col-md-8">
				<div class="">
					<input name="path_to_upload" type="text" id="path_to_upload" class="form-control" value="{{$field['option']['path_to_upload']}}" placeholder="File directory (eg. itemphoto/files)"/>
				</div>
				<div class="">
					<input name="sub_foldername" type="text" id="sub_foldername" class="form-control" value="{{@$field['option']['sub_foldername']}}" placeholder="File sub-folder (eg. large,medium,thumbnail)"/>
				</div>
				<div class="help-block">
		        	<code>NOTE:</code> For multiple sub-folder, use ",". If you leave blank this field, sub-folder name was created by resize value.
		        </div>
				<div class="checkbox icheck"> 
					<label>
						<input type="radio" name="upload_type" value="file"
						@if($field['option']['upload_type'] =='file') checked="checked" @endif
						/>  
						File 
					</label>
					&nbsp;&nbsp;&nbsp;
					<label>
						<input type="radio" name="upload_type" value="image" 
						@if($field['option']['upload_type'] =='image') checked="checked" @endif
						 />  
						Image / Picture  
					</label>
				</div>
				<div class="imgResize form-inline">
					Resize Image to ?<br>
					Width : 
					<input name="resize_width" type="text" id="resize_width" class="form-control input-sm" style=" width:55px"
					value="@if(isset($field['option']['resize_width'])) {{$field['option']['resize_width']}} @endif"
					 />
					Height : 
					<input name="resize_height" type="text" id="resize_height" class="form-control input-sm" style=" width:55px"
					value="@if(isset($field['option']['resize_height'])) {{$field['option']['resize_height']}} @endif" />
					Quality : 
					<input name="quality" type="text" id="quality" class="form-control input-sm" style=" width:55px"
					value="@if(isset($field['option']['quality'])) {{$field['option']['quality']}} @endif" />
				</div>
				<div class="help-block">
		        	<code>NOTE:</code> For multiple resize image, use "," like <code> 400,200,100 </code> and quality is <code> 80 </code>
		        </div>
		        <br>
				<label class="checkbox icheck" >
					<input type="checkbox" name="save_full_path"  value="1" @if(isset($field['option']['save_full_path']) && $field['option']['save_full_path'] =='1') checked="checked" @endif /> Save with full path url?
				</label>
				<label class="checkbox icheck" >
					<input type="checkbox" name="image_multiple"  value="1" @if(isset($field['option']['image_multiple']) && $field['option']['image_multiple'] =='1') checked="checked" @endif /> Allow Multiple Upload
				</label>
				<label class="checkbox icheck" >
					<input type="checkbox" name="save_original_image"  value="1" @if(isset($field['option']['save_original_image']) && $field['option']['save_original_image'] =='1') checked="checked" @endif /> Save Original Image
				</label>
			</div> 
		</div>

		<div class="form-group standart-form dataprefix " style="display:none;">
		    <label for="ipt" class=" text-right col-md-4">Prefix String </label>
		    <div class="col-md-8">
		        <input name="str_prefix" type="text" class="form-control" value="{{$field['option']['str_prefix']}}" placeholder="Optional" />
		    </div>
		</div>

		<div class="form-group standart-form auto-val" style="display:none;">
		    <label for="ipt" class=" text-right col-md-4">Value Type </label>
		    <div class="col-md-8">
		    	<div class="checkbox icheck">
			        <label> 
						<input type="radio" name="val_type" value="str"
						@if($field['option']['val_type'] =='str') checked="checked" @endif
						/>  
						String 
					</label>
					<label> 
						<input type="radio" name="val_type" value="num" 
						@if($field['option']['val_type'] =='num') checked="checked" @endif
						 />  
						Integer 
					</label>
		    	</div>
		    </div>
		</div>

		<div class="form-group" style="display:none;">
		    <label for="ipt" class=" text-right col-md-4">Input Format ( Masking ) </label>
		    <div class="col-md-8">
		        <select name="format" class="form-control input-sm">
		            <?php 
		            $array = array(
						'text' 			=> 'None',
						'phone'			=> 'Int Phone ',
						'currency'	 	=> 'USD Currency',
						'percent'		=> 'Percent'
					);
					?>
					@foreach($array as $val=>$item)
	                <option value="{{$val}}">{{$item}}</option>
		           	@endforeach
		        </select>
		    </div>
		</div>

		<fieldset>
		    <legend>
		        <a href="#" onclick="$( '.addhtml' ).toggle()"> <small> More Options </small> </a>
		    </legend>
		    <div class="addhtml" style="display: none">
		    	<div class="form-group">
		            <label for="ipt" class=" text-right col-md-4">Placeholder </label>
		            <div class="col-md-8">
		                <input name="placeholder" type="text" id="placeholder" class="form-control input-sm" value="{{$field['option']['placeholder']}}" />
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="ipt" class=" text-right col-md-4">Tooltip </label>
		            <div class="col-md-8">
		                <input name="tooltip" type="text" id="tooltip" class="form-control input-sm" value="{{$field['option']['tooltip']}}" />
		            </div>
		        </div>
		        <div class="form-group">
		            <label for="ipt" class=" text-right col-md-4">Help text </label>
		            <div class="col-md-8">
		                <input name="helptext" type="text" id="helptext" class="form-control input-sm" value="{{$field['option']['helptext']}}" />
		            </div>
		        </div>
		        <div class="form-group" style="display:none;">
		            <label for="ipt" class=" text-right col-md-4">Additional Class </label>
		            <div class="col-md-8">
		                <input name="extend_class" type="text" id="extend_class" class="form-control input-sm" value="{{$field['option']['extend_class']}}" />
		            </div>
		        </div>
		        <div class="form-group ">
		            <label for="ipt" class=" text-right col-md-4"> Custom <b>Prefix & Sufix </b> </label>
		            <div class="col-md-8">
		                <input name="prefix" type="text" id="prefix" class="form-control input-sm" style="width: 30% !important; float: left; margin-right: 5px; " placeholder="Prefix" value="@if(isset($field['option']['prefix'])) {{$field['option']['prefix']}} @endif" />
		                <input name="sufix" type="text" id="sufix" class="form-control input-sm" style="width: 30% !important;  float: left; " placeholder="Suffix" value="@if(isset($field['option']['sufix'])) {{$field['option']['sufix']}} @endif" />
		            </div>
		        </div>
		        <div class="form-group ">
		            <label for="ipt" class=" text-right col-md-4">Html Attribute</label>
		            <div class="col-md-8">
		                <textarea name="attribute" id="attribute" class="form-control input-sm" placeholder="style='width:50%'">{{$field['option']['attribute']}}</textarea>
		            </div>
		        </div>
		    </div>
		</fieldset>

		<div class="form-group">
		    <label for="ipt" class=" text-right col-md-4"></label>
		    <div class="col-md-8">
		        <input type="submit" class="btn green" value="Save Changes " />
		        <input type="button" class="btn btn-default" value="Cancel" data-dismiss="modal" aria-hidden="true"/>
		    </div>
		</div>
	
	</div>
</form>
<script type="text/javascript" src="{{ asset('apitoolz-assets/global/plugins/simpleclone.js') }}" ></script>
<script>
	responeFormType("{{$field['type']}}");
    responOptData("{{$field['option']['opt_type']}}");
	$(document).ready(function() {
		var dataOpt = "{{$field['option']['opt_type']}}";
		$('input[name="opt_type"]').on('ifChecked', function(event){
			dataOpt = $(this).val();
		});
		$('#_field').on('submit', function(){
			var type = $('select[name="type"]').val();
			if(type == 'file' && $('input[name="path_to_upload"]').val().length == 0)
			{
				$('input[name="path_to_upload"]').parent('div').addClass('has-error');
				return false;
			}
			if(type == 'radio' || type == 'checkbox' || type == 'select' )
			{	
				if(dataOpt != "external")
				{
					var returnForm = true;
					$('.custom_field_val').each(function(){
						if($(this).val().length == 0)
						{
							$(this).parent('div').addClass('has-error');
							returnForm = false;
						}
					});
					$('.custom_field_display').each(function(){
						if($(this).val().length == 0)
						{
							$(this).parent('div').addClass('has-error');
							returnForm = false;
						}
					});
					return returnForm;
				}else{

				}
				if(dataOpt == '')
				{
					$('.datatype').addClass('has-error');
					alert("Please check data option");
					return false;
				}
			}
			return true;
		});
	    $(".select2").select2({width:"100%"});

	    $('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
	        checkboxClass: 'icheckbox_square-red',
	        radioClass: 'iradio_square-red',
	    });

	    <?php 
		if(preg_match('/(select|radio|checkbox|auto_val)/',$field['type'])) 
		{
			 if($field['option']['opt_type'] == 'external')  { 
				echo "\$('.datalist').hide(); \$('.database').show()";	 
			 } else { 
				echo "\$('.database').hide(); \$('.datalist').show()";
			} 

		} else {
			echo "\$('.database').hide(); \$('.datalist').hide()";
		}?>

	    $("#lookup_table").jCombo("{{ URL::to('core/model/combotable') }}", {
	        selected_value: "<?php echo $field['option']['lookup_table'];?>",
	        initial_text: ' Select Table',

	    });

	    $("#lookup_key").jCombo("{{ URL::to('core/model/combotablefield') }}?table=", {
	        selected_value: "<?php echo $field['option']['lookup_key'];?>",
	        parent: "#lookup_table",
	        initial_text: ' Primary Key'
	    });

	    <?php $lv = explode("|", $field['option']['lookup_value']); ?>

	    $("#lookup_value1").jCombo("{{ URL::to('core/model/combotablefield') }}?table=", {
	        selected_value: "<?php echo (isset($lv[0]) ? $lv[0] : '');?>",
	        parent: "#lookup_table",
	        initial_text: ' Choose Field'
	    });

	    $("#lookup_value2").jCombo("{{ URL::to('core/model/combotablefield') }}?table=", {
	        selected_value: "<?php echo (isset($lv[1]) ? $lv[1] : '');?>",
	        parent: "#lookup_table",
	        initial_text: ' Choose Field'
	    });

	    $("#lookup_value3").jCombo("{{ URL::to('core/model/combotablefield') }}?table=", {
	        selected_value: "<?php echo (isset($lv[2]) ? $lv[2] : '');?>",
	        parent: "#lookup_table",
	        initial_text: ' Choose Field'
	    });

	    $('a.addC').relCopy({});

	    $('.datatype input:radio').on('ifClicked', function() {
            val = $(this).val();
            responOptData(val);

        });

	});

	function responOptData(val) {
	    if (val == 'external') {
	        $('.database').show();
	        $('.datalist').hide();
	        $('.dataprefix').hide();
	        if($('select[name="type"]').val() == 'auto_val') {
	        	$('.display').each(function($i){
	        		$(this).html('Prefix #'+($i+1)+' : ');
	        		if($i > 0) $(this).parent().hide();
	        		$('.parent-filter, .allow-multi').hide();
	        	});
	        }else{
	        	$('.display').each(function($i){
	        		$(this).parent().show();
	        		$(this).html('Display #'+($i+1)+' : ');
	        		$('.parent-filter, .allow-multi').show();
	        	});
	        }
	    } else {
	        $('.database').hide();
	        $('.datalist').show();
	        if($('select[name="type"]').val() == 'auto_val') {
	        	$('.datalist').hide();
	        	$('.dataprefix').show();
	        }
	    }
	}

	function responeFormType(val) {

	    if (val == 'select' || val == 'radio' || val == 'checkbox' || val == 'auto_val') {
	        $('.standart-form').show();
	        $('.file-upl').hide();
	        $('.database').hide();
	        $('.datalist').show();
	        $('.file-upl').hide();
	        $('.dataprefix').hide();
	        $('.auto-val').hide();
	        if (val == 'radio' || val == 'checkbox') {
	        	$('input[value="datalist"]').prop('checked',true);
	        	$('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck('destroy');
	        	$('.icheck input[type="checkbox"],.icheck input[type="radio"]').iCheck({
			        checkboxClass: 'icheckbox_square-red',
			        radioClass: 'iradio_square-red',
			    });
			    $('.datatype input:radio').on('ifClicked', function() {
		            val = $(this).val();
		            responOptData(val);
		        });
	            $('.dbasevalue').hide()
	        } else if (val == 'auto_val') {
		    	$('.auto-val').show();
		    	$('.dataprefix').show();
		    	$('.datalist').hide();
		    } else {
	            $('.dbasevalue').show()
	        }

	    } else if (val == 'file') {
	    	$('.auto-val').hide();
	        $('.standart-form').hide();
	        $('.file-upl').show();

	    } else {
	        $('.standart-form').hide();
	        $('.database').hide();
	        $('.datalist').hide();
	        $('.file-upl').hide();
	        $('.auto-val').hide();
	    }

	} 
</script>