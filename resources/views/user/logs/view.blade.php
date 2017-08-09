@extends('layouts.master') @section('content')
<div class="page-content">
    <div class="page-content-wrapper">
        <div class="portlet light bordered">
            <div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption">
                    <span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    <a href="{{ URL::to('user/logs?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back"><i class="fa fa-arrow-circle-left"></i> Back</a> @if($access['is_add'] ==1)
            		<a href="{{ URL::to('user/logs/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-primary" title="Edit"><i class="fa fa-edit"></i> Edit</a> @endif
                </div>
            <div class="portlet-body">

                <table class="table table-striped table-bordered">
                    <tbody>

                        <tr>
                            <td width='30%' class='label-view text-right'>IPs</td>
                            <td>{{ $row->ipaddress }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Users</td>
                            <td>{{ SiteHelpers::gridDisplayView($row->user_id,'user_id','1:tb_users:id:first_name') }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Module</td>
                            <td>{{ $row->module }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Task</td>
                            <td>{{ $row->task }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Note</td>
                            <td>{{ $row->note }} </td>

                        </tr>

                        <tr>
                            <td width='30%' class='label-view text-right'>Logdate</td>
                            <td>{{ $row->logdate }} </td>

                        </tr>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
</div>

@stop