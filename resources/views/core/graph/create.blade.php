@extends('core.graph.master')
@section('style')
<link href="{{ asset('apitoolz-assets/global/plugins/json-viewer/src/jquery.json-view.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('create')
<div class="portlet light portlet-form bordered">
    <div class="portlet-title">
        <div class="caption">
            <span class="caption-subject"><strong>Create {{$row->module_title}}</strong> ( Save data of {{$row->module_title}} Model )</span>
        </div>
        <div class="actions">
            
        </div>
    </div>
    <div class="portlet-body">
        <div class="row">
            <div class="col-md-6" id="_post">
                <h3>Create a {{$row->module_title}}</h3>
                <p>To crate a {{$row->module_name}}, fill value in the following form. And click on <code>submit</code> button.</p>
                <h4>Header:</h4>
                <small>
                    <b>Accept: </b> <code>application/json</code><br>
                    <b>Authorization: </b> <code>Bearer {$access_token}</code> <a href="{{url('core/graph/token')}}" onclick="_Modal(this.href,'Access Token'); return false;" class="tips" data-original-title="Edit Access Token"><i class="fa fa-edit"></i></a>
                </small>
                <h4>Form Parameter</h4>
                {!! Form::open(array('url'=>url('/api/'.$row->module_name), 'id'=>'_create','class'=>'form-horizontal','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!} 
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
                                    {!! SiteHelpers::transForm($col['Field'] , $forms, false, '', 'input-sm') !!}
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
                                            {!! SiteHelpers::transForm($col['Field'] , $f['input_group'], false, '', 'input-sm') !!}
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
                        <h4 class="panel-title">POST <i class="fa fa-long-arrow-right tips" data-original-title="{{url('/')}}"></i> /api/{{strtolower($row->module_name)}}</h4>
                    </div>
                    <div class="panel-body">
                        <h4>Response Body:<small id="create-status" class="bold"></small></h4>
                        <div class="well response" id="_post-response" style="font-size: 12px;"></div>
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
		$('#_post-response').css({"height": ($('#_post').height())+'px' });
        $('#_create').submit(function(e) {
            $('#_post-response').html('');
            $.ajax({
                url: '{{url("api/".strtolower($row->module_name))}}',
                type: 'POST',
                data: new FormData( this ),
                processData: false,
                contentType: false,
                headers: {
                    'Accept': 'application/json',
                    'Authorization': 'Bearer {{$access_token}}'
                }
            }).done(function($response) {
                $('#show-status').html('<span class="font-green">status[200]</span>');
                $('#_post-response').jsonView($response);
                document.getElementById("_create").reset();
            }).fail(function($error){
                $('#create-status').html(mFail($error));
                $('#_post-response').jsonView($error.responseJSON);
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