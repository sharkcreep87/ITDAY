<form action="{{url('core/view')}}" method="POST" class="form-horizontal" data-parsley-validate>
	{{csrf_field()}}
	<input type="hidden" value="{{ isset($field) ? $field : ''}}" name="currentfield">
	<div class="form-group">
		<label class="col-md-4">View Name</label>
		<div class="col-md-8">
			<input type="text" name="name" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4">Algorithm</label>
		<div class="col-md-8">
	        <select name="algorithm" class="form-control" >
				<option value="UNDEFINED">UNDEFINED</option>
				<option value="MERGE">MERGE</option>
				<option value="TEMPTABLE">TEMPTABLE</option>
	        </select>	
        </div>
	</div>
	<div class="form-group">
		<label class="col-md-4">As</label>
		<div class="col-md-8">
			<textarea rows="5" name="as" class="form-control" placeholder="select * from ..."></textarea>
		</div>	
	</div>
	
	<div class="form-group">
		<label class="col-md-4">  </label>
		<div class="col-md-8">
			<button type="submit" class="btn green"> Create View</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
		</div>	
	</div>
</form>
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>