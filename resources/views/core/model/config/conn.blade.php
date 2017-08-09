<form action="{{url('core/model/config/'.$row->module_id.'/conn')}}" method="post" class="form-vertical">
	{{csrf_field()}}
	<div id="result"></div>
	<div class="padding-lg">
		<div class="form-group">	
			<label> Table </label>
			<select name="db" id="db"  class="ext form-control"></select>	
		</div>	
		<div class="form-group">	
			<label> Key  </label>
			<select name="key" id="key"  class="ext form-control" required disabled="disabled"></select>	
		</div>	
		<div class="form-group">	
			<label> Display as </label>
			<div class="row">
				<div class="col-md-4">
					<select name="display[]" class="form-control" id="lookup_value1"></select> 
				</div>
				<div class="col-md-4">
					<select name="display[]" class="form-control" id="lookup_value2"></select>
				</div>
				<div class="col-md-4">
					<select name="display[]" class="form-control" id="lookup_value3"></select>
				</div>
			</div>
		</div>	
		<div class="form-group">
			<input type="hidden" name="table_field" value="{{$table_field}}">
			<input type="hidden" name="table_alias" value="{{$table_alias}}">
			<button type="submit" class="btn green" id="saveLayout"> Save Changes </button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel </button>
		 </div>	 			 
	</div>
</form>
<script>
$(document).ready(function(){
			
	$("#db").jCombo("{{ url('core/model/combotable') }}",
	{ selected_value : "{{ $conn['db'] }}" });

	<?php $display = explode("|", $conn['display']); ?>

	$("#key").jCombo("{{ url('core/model/combotablefield') }}?table=",
	{ selected_value : "{{ $conn['key'] }}", parent: "#db", initial_text : ' Primary Key' });		
	$("#lookup_value1").jCombo("{{ url('core/model/combotablefield') }}?table=",
	{ selected_value : "<?php echo (isset($display[0]) ? $display[0] : '');?>", parent: "#db",   initial_text : ' Display Text 1'});
	$("#lookup_value2").jCombo("{{ url('core/model/combotablefield') }}?table=",
	{ selected_value : "<?php echo (isset($display[1]) ? $display[1] : '');?>", parent: "#db",   initial_text : ' Display Text 2'});
	$("#lookup_value3").jCombo("{{ url('core/model/combotablefield') }}?table=",
	{ selected_value : "<?php echo (isset($display[2]) ? $display[2] : '');?>", parent: "#db",   initial_text : ' Display Text 3'});	
});	
</script>	


