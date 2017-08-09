@extends('layouts.master') @section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered animated fadeInUp ">
        	<div class="portlet-title hidden-xs">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption">
                    <i class=" font-red"></i><span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions ">
            		<a href="{{ url('admin/test?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back to Listing"><i class="fa  fa-arrow-left"></i></a> @if($access['is_add'] ==1)
                    <a href="{{ url('admin/test/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="Edit {{ $pageTitle }}"><i class="fa  fa-pencil"></i></a> @endif
                    <a href="{{ ($prevnext['prev'] != '' ? url('admin/test/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>
                    <a href="{{ ($prevnext['next'] != '' ? url('admin/test/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
            <div class="portlet-body">

                <table class="table table-striped table-bordered">
                    <tbody>
                        
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Group Id</td>
						<td>{{ $row->group_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Username</td>
						<td>{{ $row->username}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email</td>
						<td>{{ $row->email}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Staff Id</td>
						<td>{{ $row->staff_id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Phone</td>
						<td>{{ $row->phone}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>First Name</td>
						<td>{{ $row->first_name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Last Name</td>
						<td>{{ $row->last_name}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Avatar</td>
						<td>{{ $row->avatar}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Active</td>
						<td>{{ $row->active}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Login Attempt</td>
						<td>{{ $row->login_attempt}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Last Login</td>
						<td>{{ $row->last_login}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Updated At</td>
						<td>{{ $row->updated_at}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Reminder</td>
						<td>{{ $row->reminder}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Activation</td>
						<td>{{ $row->activation}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Remember Token</td>
						<td>{{ $row->remember_token}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Last Activity</td>
						<td>{{ $row->last_activity}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Entry By</td>
						<td>{{ $row->entry_by}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Created At</td>
						<td>{{ $row->created_at}} </td>
						
					</tr>
				
                    </tbody>
                </table>

                

            </div>
        </div>

    </div>
</div>

@stop