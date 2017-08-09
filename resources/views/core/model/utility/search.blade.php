<div >
<form id="{{$pageModule}}Search">
<table class="table search-table table-striped" id="advance-search">
	<tbody>
	@foreach ($tableForm as $t)
		@if($t['search'] =='1')
			<tr id="{{ $t['field'] }}" class="fieldsearch">
				<td>{!! $t['label'] !!} </td>
				<td > 
				<select id="{{ $t['field']}}_operate" class="form-control oper" name="operate" onchange="changeOperate(this.value , '{{ $t['field']}}')">
					<option value="equal"> = </option>
					<option value="bigger_equal"> >= </option>
					<option value="smaller_equal"> <= </option>
					<option value="smaller"> < </option>
					<option value="bigger"> > </option>
					<option value="not_null"> ! Null  </option>
					<option value="is_null"> Null </option>
					<option value="between"> Between </option>
					<option value="like"> Like </option>	

				</select> 
				</td>
				<td id="field_{{ $t['field']}}">{!! SiteHelpers::transForm($t['field'] , $tableForm, false, '', 'input-sm', true) !!}</td>
			
			</tr>
		
		@endif
	@endforeach
		<tr>
			<td></td>
			<td colspan="2">
				<button type="button" name="search" class="doSearch btn btn-success"> Search </button>
				<button type="button" data-dismiss="modal" aria-hidden="true" name="cancel" class="btn btn-default"> Cancel </button>
			</td>
		</tr>
	</tbody>     
	</table>
</form>	
</div>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
<script>
function changeOperate( val , field )
{
	if(val =='is_null') {
		$('input[name='+field+']').attr('readonly','1');
		$('input[name='+field+']').val('is_null');
	} else if(val =='not_null') {
		$('input[name='+field+']').attr('readonly','1');
		$('input[name='+field+']').val('not_null');		

	} else if(val =='between') {
	
		html = '<input name="'+field+'" class="date form-control" placeholder="Start Date" style="width:150px;"  /> -  <input name="'+field+'_end" class="date form-control"  placeholder="End Date" style="width:150px;"    />';
		$('#field_'+field+'').html(html);
	} else {
		//$('input[name='+field+']').removeAttr('readonly');
		$('#field_'+field+'').html('<input type="text" value="" class="form-control " name="'+field+'">');
		$('input[name='+field+']').val('');	
		
	}
}
jQuery(function(){

	$('.date').datepicker({format:'yyyy-mm-dd',autoClose:true});
	$('.datetime').datetimepicker({format: 'yyyy-mm-dd hh:ii:ss'}); 
	$('.select2').select2({width:"100%"});

	$('.doSearch').click(function(){
		//alert('test');
		var attr = '';
		$('#advance-search tr.fieldsearch').each(function(i){
			var field = $(this).attr('id');
			var operate = $(this).find('#'+field+'_operate').val();
			var value_select  = $(this).find("select[name="+field+"] option:selected").val();
			if( typeof value_select !=='undefined' )
			{
				value  = value_select;
			} else {
				value  = $(this).find("input[name="+field+"]").val();
			}

			if(value !=='' && typeof value !=='undefined' && this.name !='_token')
			{

				if(operate =='between')
				{
					var value  = $(this).find("input[name="+field+"]").val();
					var value2  = $(this).find("input[name="+field+"_end]").val();
					attr += field+':'+operate+':'+value+':'+value2+'|';
				} else {
					attr += field+':'+operate+':'+value+'|';
				}	
					
			}
			
		});
		
		window.location.href = '{{ $pageUrl }}?search='+attr;
	});


});

</script>
