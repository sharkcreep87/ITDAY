@extends('core.graph.master')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('index')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>{{$row->module_title}} List</strong> ( List all of {{$row->module_title}} Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_get">
                <h3>List all {{$row->module_title}}</h3>
                <p>Manage your API as default rows limit, sorting by, filter with default value.</p>
                {!! Form::open(array('url'=>'core/graph/'.$row->module_id.'/index', 'class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')) !!} 
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
                                        <input type="checkbox" name="api[{{$key}}]" @if($grid[$key]['api'] == 1) checked @endif /> </td>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4>Request Parameter</h4>
                    
                    <div class="table-scrollable">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th> Param Name </th>
                                    <th> Value </th>
                                    <th> </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td> Page </td>
                                    <td> 
                                        <input type="text" name="page" value="@if(isset($request['page'])){{$request['page']}}@else{{1}}@endif" class="form-control input-sm" parsley-type="number" required> 
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Rows </td>
                                    <td> 
                                        <input type="text" name="rows" value="@if(isset($request['rows'])){{$request['rows']}}@else{{10}}@endif" class="form-control input-sm" parsley-type="number" required> 
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Sort </td>
                                    <td> 
                                        <select name="sort" class="form-control select2">
                                            @foreach($grid as $key=>$grd)
                                                @if($grd['sortable'] == 1)
                                                <option value="{{$grd['field']}}" @if(isset($request['sort']) && $request['sort'] == $grd['field']) selected @endif>{{$grd['field']}}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        Default
                                    </td>`
                                </tr>
                                <tr>
                                    <td> Order </td>
                                    <td> 
                                        <select name="order" class="form-control select2">
                                            <option value="asc" @if(isset($request['order']) && $request['order'] == 'asc') selected @endif>asc</option>
                                            <option value="desc" @if(isset($request['order']) && $request['order'] == 'desc') selected @endif>desc</option>
                                        </select>
                                    </td>
                                    <td>
                                        Default
                                    </td>
                                </tr>
                                <tr>
                                    <td> Search </td>
                                    <td> 
                                        <input type="text" name="search" value="@if(isset($request['search'])){{$request['search']}}@endif" id="search" class="form-control input-sm"> 
                                    </td>
                                    <td>
                                        <a href="{{url('core/graph/builder/'.$row->module_id.'/search')}}" class="btn btn-sm green" onclick="_Modal(this.href,'Search Builder'); return false;"><i class="fa fa-wrench"></i> Build</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="note note-danger">
                        <p>If you changed default parameter values, it will set default values in your API. </p>
                    </div>
                    <button type="submit" class="btn red-mint btn-outline sbold">Save changes</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">GET <i class="fa fa-long-arrow-right tips" data-original-title="{{url('/')}}"></i> /api/{{strtolower($row->module_name)}}</h4>
                    </div>
                    <div class="panel-body">
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code>  <a href="{{url('core/graph/token')}}" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Request Param:</h4>
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/{{strtolower($row->module_name)}}"></i> 
                        <code id="request-param">?page=@if(isset($request['page'])){{$request['page']}}@else{{1}}@endif&rows=@if(isset($request['rows'])){{$request['rows']}}@else{{10}}@endif&sort=@if(isset($request['sort'])){{$request['sort']}}@else{{'id'}}@endif&order=@if(isset($request['order'])){{$request['order']}}@else{{'asc'}}@endif&search=@if(isset($request['search'])){{$request['search']}}@endif</code>
                        <h4>Response Body:<small id="_get-status" class="bold"></small></h4>
                        <div class="well response" id="_get-response" style="font-size: 12px;"></div>
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
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
<script type="text/javascript">
	$(document).ready(function () {
		$('#_get-response').css({"height": ($('#_get').height() - 150)+'px' });

        $.ajax({
            url: '{{url("api/".strtolower($row->module_name))}}'+$('#request-param').html().replace(/&amp;/g,"&"),
            type: 'GET',
            dataType: 'json',
            headers: {
                'Accept': 'application/json',
                'Authorization': 'Bearer {{$access_token}}'
            },
            contentType: 'application/json; charset=utf-8',
            success: function ($result) {
                $('#_get-status').html('<span class="font-green">status[200]</span>');
                $('#_get-response').jsonView($result);
            },
            error: function ($error) {
                $('#_get-status').html(mFail($error));
                $('#_get-response').jsonView($error.responseJSON);
            }
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