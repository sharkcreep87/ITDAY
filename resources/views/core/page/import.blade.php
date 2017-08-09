<form action="{{url('core/page/import')}}" method="POST"  class="form-horizontal" data-parsley-validate enctype="multipart/form-data">
    {{csrf_field()}}
    <input type="hidden" value="{{ isset($field) ? $field : ''}}" name="currentfield">
    <div class="form-group">
        <label class="col-md-3 text-right">Upload Installer (Zip File) : </label>
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
                        <input type="file" name="installer"> </span>
                    <a href="javascript:;" class="input-group-addon btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                </div>
            </div>
            <span class="help-block">The file extention must be <code>.zip</code>.</span>
        </div>
    </div>
    <div class="form-group">
        <hr>
        <div class="col-md-9 col-md-offset-3">
            <button type="submit" class="btn green"> Import </button>
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
        </div>  
    </div>
</form>