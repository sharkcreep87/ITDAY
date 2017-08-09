<form action="{{url('core/model')}}" method="POST" class="form-horizontal" data-parsley-validate>
    {{csrf_field()}}
    <input type="hidden" value="{{ isset($field) ? $field : ''}}" name="currentfield">
    <div class="form-group">
        <label class="col-md-4 text-right">Name : </label>
        <div class="col-md-8">
            <input type="text" name="name" value="{{ isset($field) ? $field : ''}}" class="form-control" required>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 text-right">Note : </label>
        <div class="col-md-8">
            <textarea name="note" rows="3" class="form-control"></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-4 text-right">Choose table : </label>
        <div class="col-md-8">
            <select name="table" class="form-control" >
                @foreach($tables as $t)
                <option value="{{ $t }}">{{ $t }}</option>
                @endforeach
            </select>
        </div>  
    </div>    

    <div class="form-group">
        <label class="col-md-4"></label>
        <div class="col-md-8 icheck">
            <label class="checkbox"><input type="checkbox" name="active" value="1" /> Active </label>
        </div>  
    </div>
    <div class="form-group">
        <label class="col-md-4"></label>
        <div class="col-md-8 icheck">
            <label class="checkbox"><input type="checkbox" name="type" value="report" /> Create report view only. </label>
        </div>  
    </div>

    <div class="form-group">
        <hr>
        <label class="col-md-4">  </label>
        <div class="col-md-8">
            <button type="submit" class="btn green"> Create Model </button>
            <button type="button" class="btn btn-default" data-dismiss="modal" aria-hidden="true"> Cancel</button>
        </div>  
    </div>
</form>
<script src="{{ asset('apitoolz-assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    $('.icheck input[type="checkbox"],input[type="radio"]').iCheck({
        checkboxClass: 'icheckbox_square-red',
        radioClass: 'iradio_square-red',
    });
</script>