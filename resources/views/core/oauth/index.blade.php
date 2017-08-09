@extends('layouts.system')
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-fit portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-screen-tablet font-red"></i>
                        <span class="caption-subject font-red bold">Manage Client</span>
                    </div>
                    <div class="actions">
                        <a href="javascript:;" onclick="_Modal('{{url("core/oauth/create")}}','New OAuth Client');" class="btn green"><i class="fa fa-plus"></i> Create New Client</a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row no-margin margin-bottom-20">
                        <div class="col-md-12">
                            <!-- <div class="text-right">
                                <a href="javascript:;" class="btn bold">Import table(s)</a>
                            </div> -->
                            <div class="panel panel-default">
                                @if (session('message'))
                                    <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <!-- <div class="panel-heading"> Panel heading without title </div> -->
                                <div class="panel-body" id="form-content">
                                    <table class="table table-striped">
		                                <thead>
		                                    <tr>
		                                        <th> Client Name </th>
		                                        <th> Client ID </th>
		                                        <th> Client Secret </th>
		                                        <th> Action </th>
		                                    </tr>
		                                </thead>
		                                <tbody>
		                                @foreach($rows as $row)
		                                    <tr>
		                                        <td> {{ $row->name }} </td>
		                                        <td> {{ $row->id }} </td>
		                                        <td> {{ $row->secret }} </td>
		                                        <td>
		                                            <a href="javascript:;" onclick="_Modal('{{url("core/oauth/".$row->id."/token")}}','Client Access Token');return false;" class="btn btn-sm btn-primary"> Generate Token </a>
		                                            <a href="{{url('core/oauth/'.$row->id.'/destroy')}}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure to delete?')"> Delete </a> 
		                                        </td>
		                                    </tr>
		                                @endforeach
		                                </tbody>
		                            </table>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
@endsection
@section('plugin')
@endsection
@section('script')
@endsection