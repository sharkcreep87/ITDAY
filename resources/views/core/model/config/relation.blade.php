@extends('core.model.config')
@section('relation')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>{{$row->module_title}} Relation</strong> ( Add relation of Model) </span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
    	<form action="{{url('core/model/config/'.$row->module_id.'/relation')}}" method="post" class="form-horizontal" data-parsley-validate>
    		{{csrf_field()}}
	        <input type='hidden' name='master' id='master' value='{{ $row->module_name }}' />
	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"> Link Title <code>*</code></label>
	            <div class="col-md-6">
	                <input type="text" name="title" class="form-control" required>
	                <i class="text-danger"> Important ! ,  <small> Do  not use white space </small></i>
	            </div>
	        </div>

	        <div class="form-group">
	            <label class="control-label col-md-4"> Relation Type : </label>
	            <div class="col-md-6 radio-group icheck">
	                <input type="radio" name="relation" value="belongsTo" checked /> belongsTo
	                <input type="radio" name="relation" value="hasMany" /> hasMany
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Master Key <code>*</code></label>
	            <div class="col-md-6">

	                <select name="master_key" id="master_key" required="true" class="form-control">
	                    @foreach($config['grid'] as $field)
                        <option value="{{$field['field']}}">
                            {{$field['field']}}
                        </option>
	                    @endforeach
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"> Relation Model </label>
	            <div class="col-md-6">
	                <select name="module" id="module" required="true" class="form-control">
	                    <option value="">-- Select Model --</option>
	                    @foreach($modules as $module)
                        <option value="{{$module->module_name}}">
                            {{$module->module_title}}
                        </option>
	                    @endforeach
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Relation Table <code>*</code></label>
	            <div class="col-md-6">
	                <select name="table" id="table" required="true" class="form-control">
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4">Detail Key <code>*</code></label>
	            <div class="col-md-6">
	                <select name="key" id="key" required="true" class="form-control">
	                </select>
	            </div>
	        </div>

	        <div class="form-group">
	            <label for="ipt" class=" control-label col-md-4"></label>
	            <div class="col-md-6">
	                <button name="submit" type="submit" class="btn green"> Save Form </button>
	            </div>
	        </div>

	    </form>

        <div class="table-responsive" style="margin-bottom:40px;">

            <table class="table table-striped">
                <thead class="no-border">
                    <tr>
                        <th>Title</th>
                        <th>Relation Type</th>
                        <th>Master Key</th>
                        <th>Relation Model</th>
                        <th data-hide="phone">Relation Table</th>
                        <th data-hide="phone">Relation Key</th>
                        <th data-hide="phone">Action</th>
                    </tr>
                </thead>
                <tbody class="no-border-x no-border-y">
                    @foreach($config['subgrid'] as $rows)
                    <tr>
                        <td>
                            {{$rows['title']}}
                        </td>
                        <td>
                            {{$rows['relation']}}
                        </td>
                        <td>
                            {{$rows['master_key']}}
                        </td>
                        <td>
                            {{$rows['module']}}
                        </td>
                        <td>
                            {{$rows['table']}}
                        </td>
                        <td>
                            {{$rows['key']}}
                        </td>
                        <td><a href="{{url('core/model/config/'.$row->module_id.'/relation/remove?module='.$rows['module'])}}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> </a></td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>
</div>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript" >
    $(document).ready(function() {
        $("#table").jCombo("{{ url('core/model/combotable') }}", {});
        $("#key").jCombo("{{ url('core/model/combotablefield') }}?table=", {
            parent: "#table"
        });
    });
</script>
@endsection