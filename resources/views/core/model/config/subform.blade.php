@extends('core.model.config')
@section('subform')
<form action="{{url('core/model/config/'.$row->module_id.'/subform')}}" method="post" class="form-horizontal" data-parsley-validate>
	{{csrf_field()}}
	<input type='hidden' name='master' id='master' value='{{ $row->module_name }}' />
	<div class="form-group {{ $errors->has('title') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4"> Subform Title <code>*</code></label>
	    <div class="col-md-6">
	        <input type="text" name="title" value="{{isset($config['subform']['title']) ? $config['subform']['title']: ''}}" class="form-control" required>
	        @if ($errors->has("title"))
			<span class="help-block">
				<strong>{{ $errors->first("title") }}</strong>
			</span>
			@endif
	    </div>
	</div>

	<div class="form-group {{ $errors->has('master_key') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4">Master Form Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="master_key" id="master_key" required="true" class="form-control">
	            @foreach($config['grid'] as $field)
	            <option value="{{$field['field']}}" @if(isset($config['subform'][ 'master_key']) && $config['subform'][ 'master_key']==$field[ 'field']) selected @endif>
	                {{$field['field']}}
	            </option>
	            @endforeach
	        </select>
	        @if ($errors->has("master_key"))
			<span class="help-block">
				<strong>{{ $errors->first("master_key") }}</strong>
			</span>
			@endif
	    </div>
	</div>

	<div class="form-group {{ $errors->has('module') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4"> Take <b>FORM</b> from Model </label>
	    <div class="col-md-6">
	        <select name="module" id="module" required="true" class="form-control">
	            <option value="">-- Select Model --</option>
	            @foreach($modules as $module)
	                <option value="{{$module->module_name}}" @if(isset($config['subform']['module']) && $config['subform'][ 'module']==$module->module_name)  selected @endif >
	                    {{$module->module_title}}
	                </option>
	            @endforeach
	        </select>
	        @if ($errors->has("module"))
			<span class="help-block">
				<strong>{{ $errors->first("module") }}</strong>
			</span>
			@endif
	    </div>
	</div>
	<div class="form-group {{ $errors->has('module_table') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Table <code>*</code></label>
	    <div class="col-md-6">
	        <select name="table" id="module_table" required="true" class="form-control">
	        </select>
	        @if ($errors->has("module_table"))
			<span class="help-block">
				<strong>{{ $errors->first("module_table") }}</strong>
			</span>
			@endif
	    </div>
	</div>

	<div class="form-group {{ $errors->has('primary_key') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Primary Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="primary_key" id="primary_key" required="true" class="form-control">
	        </select>
	        @if ($errors->has("primary_key"))
			<span class="help-block">
				<strong>{{ $errors->first("primary_key") }}</strong>
			</span>
			@endif
	    </div>
	</div>

	<div class="form-group {{ $errors->has('key') ? 'has-error' : '' }} ">
	    <label for="ipt" class=" control-label col-md-4">Sub Form Relation Key <code>*</code></label>
	    <div class="col-md-6">
	        <select name="key" id="key" required="true" class="form-control">
	        </select>
	        @if ($errors->has("key"))
			<span class="help-block">
				<strong>{{ $errors->first("key") }}</strong>
			</span>
			@endif
	    </div>
	</div>

	<div class="form-group">
	    <label for="ipt" class=" control-label col-md-4"></label>
	    <div class="col-md-6">
	        <button name="submit" type="submit" class="btn green"><i class="fa fa-save"></i> Save Form </button>
	        @if(isset($config['subform']['master_key']))
	        <a href="{{ url('core/model/config/'.$row->module_id.'/subform/remove') }}" class="btn btn-danger" onclick="return confirm('Are you sure want to remove?');"><i class="fa fa-close "></i> Remove </a> 
	        @endif
	    </div>
	</div>

</form>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        $('.format_info').popover()

        var fixHelperModified = function(e, tr) {
                var $originals = tr.children();
                var $helper = tr.clone();
                $helper.children().each(function(index) {
                    $(this).width($originals.eq(index).width())
                });
                return $helper;
            },
            updateIndex = function(e, ui) {
                $('td.index', ui.item.parent()).each(function(i) {
                    $(this).html(i + 1);
                });
                $('.reorder', ui.item.parent()).each(function(i) {
                    $(this).val(i + 1);
                });
            };

        $("#table tbody").sortable({
            helper: fixHelperModified,
            stop: updateIndex
        });

        $("#module_table").jCombo("{{ url('core/model/combotable') }}", {
            selected_value: "{{ (isset($config['subform']['table']) ? $config['subform']['table']: null ) }}"
        });
        $("#primary_key").jCombo("{{ url('core/model/combotablefield') }}?table=", {
            parent: "#module_table",
            selected_value: "{{ (isset($config['subform']['primary_key']) ? $config['subform']['primary_key']: null ) }}"
        });
        $("#key").jCombo("{{ url('core/model/combotablefield') }}?table=", {
            parent: "#module_table",
            selected_value: "{{ (isset($config['subform']['key']) ? $config['subform']['key']: null ) }}"
        });
    });
</script>
@endsection
