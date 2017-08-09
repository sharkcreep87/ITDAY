<form action="{{url('core/table/import')}}" method="POST" class="form-horizontal" data-parsley-validate enctype="multipart/form-data">
	{{csrf_field()}}
	<div class="form-group">
		<label class="col-md-3">Upload SQL File </label>
		<div class="col-md-9">
			<div class="fileinput fileinput-new" data-provides="fileinput" required>
                <div class="input-group input-large">
                    <div class="form-control uneditable-input input-fixed input-medium" data-trigger="fileinput">
                        <i class="fa fa-file fileinput-exists"></i>&nbsp;
                        <span class="fileinput-filename"> </span>
                    </div>
                    <span class="input-group-addon btn default btn-file">
                        <span class="fileinput-new"> Select file </span>
                        <span class="fileinput-exists"> Change </span>
                        <input type="file" name="sql"> </span>
                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                </div>
            </div>
            <span class="help-block">The file extention must be <code>.sql</code>.</span>
		</div>
	</div>
	
	<div class="form-group">
		<label class="col-md-3">  </label>
		<div class="col-md-9">
			<button type="submit" class="btn green"> Import</button>
			<button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
		</div>	
	</div>
</form>
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>