<form action="{{url('core/table/'.$table.'/field')}}" method="POST" class="form-horizontal" data-parsley-validate>
	{{csrf_field()}}
	<input type="hidden" value="{{ isset($field) ? $field : ''}}" name="currentfield">
	<div class="form-group">
		<label class="col-md-4">Column Name </label>
		<div class="col-md-8">
			<input type="text" name="field" value="{{ isset($field) ? $field : ''}}" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4"> DataType </label>
		<div class="col-md-8">
	        <select name="type" class="form-control" >
				@foreach($tbtypes as $t)
				 <option value="{{ $t }}" @if(isset($type) && $type ==$t) selected @endif >{{ $t }}</option>
				@endforeach
	        </select>	
        </div>
	</div>
	<div class="form-group">
		<label class="col-md-4">Lenght/Values </label>
		<div class="col-md-8">
			<input type="text" name="lenght" value="{{ isset($lenght) ? $lenght : ''}}" class="form-control">
		</div>	
	</div>
	<div class="form-group">
		<label class="col-md-4"> Default </label>
		<div class="col-md-8">
			<input type="text" name="default" value="{{ isset($default) ? $default : ''}}" class="form-control">
		</div>	
	</div>
	
	<div class="form-group">
		<label class="col-md-4"> After Column(s) </label>
		<div class="col-md-8">
	        <select name="position_field" class="form-control" >
	        	<option value=""> -- Select Column Postion -- </option>
				@foreach($fields as $f)
				 <option value="{{ $f['Field'] }}" >{{ $f['Field'] }}</option>
				@endforeach
	        </select>	
        </div>
	</div>	

	<div class="form-group">
		<label class="col-md-4"> Position  </label>
		<div class="col-md-8">
			<label class="checkbox"><input type="checkbox" name="position" value="FIRST" /> At beginning of table</label>
		</div>	
	</div>		

	<div class="form-group">
		<label class="col-md-4"> Option  </label>
		<div class="col-md-8">
			
			<label class="checkbox"><input type="checkbox" name="null" value="1" @if(isset($notnull) && $notnull =='NO') checked="checked" @endif /> Not Null ?</label>
			<label class="checkbox hide"><input type="checkbox" name="key" value="1"  @if(isset($key) && $key =='PRI') checked="checked" @endif /> Primary Key  ?</label>
			<label class="checkbox hide"><input type="checkbox" name="ai" value="1" @if(isset($ai) && $ai =='auto_increment') checked="checked" @endif /> Autoincrement </label>
		</div>	
		
		
	</div>	

	<div class="form-group">
		<label class="col-md-4">  </label>
		<div class="col-md-8">
			<button type="submit" class="btn green"> Save Column</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
		</div>	
	</div>
</form>
<script src="{{ asset('apitoolz-assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
	$('input[type="checkbox"],input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });
</script>