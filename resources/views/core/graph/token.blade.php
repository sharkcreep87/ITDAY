<form action="{{url('core/graph/token')}}" method="POST" class="form-horizontal" data-parsley-validate>
	{{csrf_field()}}
	<input type="hidden" value="{{ isset($field) ? $field : ''}}" name="currentfield">
	<div class="form-group">
		<label class="col-md-4">Client ID</label>
		<div class="col-md-8">
			<input type="text" name="id" value="{{$id}}" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4">Client Name</label>
		<div class="col-md-8">
			<input type="text" name="name" value="{{$name}}" class="form-control" required>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-4">Client Secret</label>
		<div class="col-md-8">
	        <input type="text" name="secret" value="{{$secret}}" class="form-control">
        </div>
	</div>
	<div class="form-group">
		<label class="col-md-4">Current Access Token </label>
		<div class="col-md-8">
			<textarea type="text" name="accesss_token" rows="5" class="form-control">{{$accesss_token}}</textarea>
		</div>	
	</div>
	<div class="form-group">
		<label class="col-md-4">  </label>
		<div class="col-md-8">
			<button type="submit" class="btn green"> New Token </button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
		</div>	
	</div>
</form>