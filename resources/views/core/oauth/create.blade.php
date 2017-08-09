 {!! Form::open(array('url'=>'core/oauth', 'class'=>'form-horizontal ','data-parsley-validate'=>'')) !!}
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4"> Client Name </label>
  	<div class="col-md-8">
      <input name="name" type="text" id="name" class="form-control input-sm" value="" required="true" /> 
  	</div> 
  </div>  
  <div class="form-group">
    <label for="ipt" class=" control-label col-md-4">  </label>
  	<div class="col-md-8">
      <button type="submit" name="submit" class="btn green">Save</button>
  		<button type="button" data-dismiss="modal" aria-hidden="true" name="search" class="doSearch btn btn-default"> Cancel </button>
  	</div> 
  </div>
 {!! Form::close() !!}
 <script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>