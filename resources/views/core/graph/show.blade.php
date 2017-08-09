@extends('core.graph.master')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('show')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>Retrieve {{$row->module_title}}</strong> ( Get data of {{$row->module_title}} Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_show">
                <h3>Retrieve a {{$row->module_title}}</h3>
                <p>To retrieve a {{$row->module_name}} detail, click on <code> <i class="fa fa-long-arrow-right"></i> /id</code> and change id <code>value</code> that you want to retrieve an record.</p>

                {!! Form::open(array('url'=>'core/graph/'.$row->module_id.'/show', 'class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!} 
                    <input type="hidden" name="api_detail" value="true">
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> # </th>
                                    <th> Field </th>
                                    <th> Type </th>
                                    <th> Show </th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($columns as $key=>$col)
                                <tr>
                                    <td> {{$key + 1}} </td>
                                    <td> {{$col['Field']}} @if($col['Key'] == 'PRI') ({{$col['Key']}}) @endif</td>
                                    <td> {{$col['Type']}} </td>
                                    <td class="icheck">
                                        @if(isset($forms[$key]['api']))
                                        <input type="checkbox" name="api[{{$key}}]" @if($forms[$key]['api'] == 1) checked @endif /> </td>
                                        @else
                                        <input type="checkbox" name="api[{{$key}}]" @if($grid[$key]['api'] == 1) checked @endif /> </td>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <button type="submit" class="btn red-mint btn-outline sbold">Save changes</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">GET <i class="fa fa-long-arrow-right tips" data-original-title="{{url('/')}}"></i> /api/{{strtolower($row->module_name)}}/{id}</h4>
                    </div>
                    <div class="panel-body">
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code> <a href="{{url('core/graph/token')}}" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Request Param:</h4>
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/{{strtolower($row->module_name)}}/{id}"></i> 
                        <code id="url-param"> / <a href="javascript:;" id="show-id" data-type="text" data-pk="1" data-original-title="Enter id value"> id </a></code>
                        <h4>Response Body:<small id="show-status" class="bold"></small></h4>
                        <div class="well response" id="_show-response" style="font-size: 12px;"></div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.js') }}" type="text/javascript"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/js/bootstrap-editable.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function() {
		$('#_show-response').css({"height": ($('#_show').height())+'px' });
        $("#show-id").editable( {
            type: "number", 
            pk: 1, 
            name: "id", 
            title: "Enter id value",
            success: function(response, newValue) {
                $('#_show-response').html('');
                $.ajax({
                    url: '{{url("api/".strtolower($row->module_name))}}/'+newValue,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer {{$access_token}}'
                    },
                    contentType: 'application/json; charset=utf-8',
                    success: function ($response) {
                        $('#show-status').html('<span class="font-green">status[200]</span>');
                        $('#_show-response').jsonView($response);
                    },
                    error: function ($error) {
                        $('#show-status').html(mFail($error));
                        $('#_show-response').jsonView($error.responseJSON);
                    }
                });
            },
        });

        var mFail = function($error){
            if($error.status == 400)
            {
                return '<span class="font-yellow-gold">status['+ $error.status+']</span>';
            }else
            {
                return '<span class="font-red">status['+ $error.status+']</span>';
            }
            return '';
        }
	})
</script>
@endsection