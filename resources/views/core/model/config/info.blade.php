@extends('core.model.config')
@section('info')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>{{$row->module_title}} Basic Info</strong>  ( Information of Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <form action="{{url('core/model/config/'.$row->module_id.'/info')}}" method="post" class="form-horizontal" data-parsley-validate>
            {{csrf_field()}}
            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Name / Title </label>
                <div class="col-md-6">
                    <input type='text' name='module_title' id='module_title' class="form-control " required value='{{ $row->module_title }}' />
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Note</label>
                <div class="col-md-6">
                    <textarea name='module_note' id='module_note' rows="3" class="form-control ">{{ $row->module_note }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Class Controller </label>
                <div class="col-md-6">
                    <input type='text' name='module_name' id='module_name' readonly="1" class="form-control " required value='{{ ucwords($row->module_name) }}Controller' />
                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4">Table</label>
                <div class="col-md-6">
                    <input type='text' name='module_db' id='module_db' readonly="1" class="form-control " required value='{{ $row->module_db}}' />

                </div>
            </div>

            <div class="form-group">
                <label for="ipt" class=" control-label col-md-4"></label>
                <div class="col-md-6">
                    <button type="submit" name="submit" class="btn green"> Save changes </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection