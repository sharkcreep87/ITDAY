@extends('core.graph.master')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-editable/bootstrap-editable/css/bootstrap-editable.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('update')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>Update {{$row->module_title}}</strong> ( Change data of {{$row->module_title}} Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_update">
                <h3>Update a {{$row->module_title}}</h3>
                <p>To update a {{$row->module_name}}, click on <code> <i class="fa fa-long-arrow-right"></i> /id</code> and change id <code>value</code> that you want to update an record.</p>
                <p>Change in following form parameter that you want, and click on <code>submit</code> button.</p>
                <h4>Header:</h4>
                <small>
                    <b>Accept: </b> <code>application/json</code><br>
                    <b>Authorization: </b> <code>Bearer {$access_token}</code>
                </small>
                <h4>Form Parameter</h4>
                {!! Form::open(array('url'=>url('api/'.strtolower($row->module_name)), 'id'=>'_update-form','class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')) !!} 
                {{ method_field('PUT') }}
                <div class="table-scrollable">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th> # </th>
                                <th> Field </th>
                                <th> Type </th>
                                <th> Value </th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1; ?>
                        @foreach($forms as $key=>$f)
                            <?php 
                                $col = $columns[array_search($f['field'], array_column($columns, 'Field'))]; 
                            ?>
                            @if($col['Key'] != 'PRI' && $f['view'] == 1 && $f['type'] != 'hidden')
                            <tr>
                                <td> {{$i}} </td>
                                <td> {{$col['Field']}} </td>
                                <td width="100px;"> {{$col['Type']}} </td>
                                <td width="250px;">
                                    {!! SiteHelpers::transForm($col['Field'] , $forms, false, '', 'input-sm '.$col['Field']) !!}
                                </td>
                            </tr>
                            <?php $i++; ?>
                            @endif

                            <!-- Input Group -->
                            @if(isset($f['input_group']) && count($f['input_group']) > 0)
                                @foreach($f['input_group'] as $input_f)
                                    <?php 
                                        $col = $columns[array_search($input_f['field'], array_column($columns, 'Field'))]; 
                                    ?>
                                    @if($col['Key'] != 'PRI' && $input_f['view'] == 1 && $input_f['type'] != 'hidden')
                                    <tr>
                                        <td> {{$i}} </td>
                                        <td> {{$col['Field']}} </td>
                                        <td width="100px;"> {{$col['Type']}} </td>
                                        <td width="250px;">
                                            {!! SiteHelpers::transForm($col['Field'] , $f['input_group'], false, '', 'input-sm '.$col['Field']) !!}
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn red-mint btn-outline sbold">Submit</button>
                {!! Form::close() !!}
            </div>
            <div class="col-md-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h4 class="panel-title">PUT <i class="fa fa-long-arrow-right tips font-lowercase" data-original-title="{{url('/')}}"></i> /api/{{strtolower($row->module_name)}}/{id}</h4>
                    </div>
                    <div class="panel-body">
                        <i class="fa fa-long-arrow-right tips" data-original-title="/api/{{strtolower($row->module_name)}}/{id}"></i> 
                        <code id="url-param"> / <a href="javascript:;" id="update-id" data-type="text" data-pk="1" data-original-title="Enter id value"> id </a></code>
                        <h4>Header:</h4>
                        <small>
                            <b>Accept: </b> <code>application/json</code><br>
                            <b>Authorization: </b> <code>Bearer {$access_token}</code> <a href="{{url('core/graph/token')}}" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                        </small>
                        <h4>Response Body:<small id="_update-status" class="bold"></small></h4>
                        <div class="well response" id="_update-response" style="font-size: 12px;"></div>
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
		$("#update-id").editable( {
            type: "number", 
            pk: 1, 
            name: "id", 
            title: "Enter id value",
            success: function(response, newValue) {
                $('#_update-response').html('');
                $.ajax({
                    url: '{{url("api/".strtolower($row->module_name))}}/'+newValue,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': '{{$access_token}}'
                    },
                    contentType: 'application/json; charset=utf-8',
                    success: function ($response) {
                        $('#_update-status').html('<i class="font-green">status[200]</i>');
                        $('#_update-response').jsonView($response);
                        $('select.select2').select2('destroy');
                        @foreach($forms as $f)
                            @if($f['type'] == 'file')
                                $("#_update-form tbody").append('<input type="hidden" name="{{$f['field']}}" value="'+$response.{{$f['field']}}+'" />');
                            @else
                                $(".{{$f['field']}}").val($response.{{$f['field']}});
                            @endif
                            @if(isset($f['input_group']) && count($f['input_group']) > 0)
                                @foreach($f['input_group'] as $f)
                                    @if($f['type'] == 'file')
                                        $("#_update-form tbody").append('<input type="hidden" name="{{$f['field']}}" value="'+$response.{{$f['field']}}+'" />');
                                    @else
                                        $(".{{$f['field']}}").val($response.{{$f['field']}});
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        $('.select2').select2();
                    },
                    error: function ($error) {
                        $('#_update-status').html(mFail($error));
                        $('#_update-response').jsonView($error.responseJSON);
                    }
                });
            },
        });

        $('#_update-response').css({"height": ($('#_update').height())+'px' });
        $('#_update-form').submit(function(e) {
            $('#_update-response').html('');
            $.ajax({
                url: '{{url("api/".strtolower($row->module_name))}}/'+$('#update-id').html(),
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{$access_token}}'
                }
            }).done(function($response) {
                $('#_update-status').html('<span class="font-green">status[200]</span>');
                $('#_update-response').jsonView($response);
            }).fail(function($error){
                $('#_update-status').html(mFail($error));
                $('#_update-response').jsonView($error.responseJSON);
            });
            e.preventDefault();
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