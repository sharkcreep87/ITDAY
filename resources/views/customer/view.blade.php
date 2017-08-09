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
            		<a href="{{ url('admin/customer?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back to Listing"><i class="fa  fa-arrow-left"></i></a> @if($access['is_add'] ==1)
                    <a href="{{ url('admin/customer/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="Edit {{ $pageTitle }}"><i class="fa  fa-pencil"></i></a> @endif
                    <a href="{{ ($prevnext['prev'] != '' ? url('admin/customer/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>
                    <a href="{{ ($prevnext['next'] != '' ? url('admin/customer/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
            <div class="portlet-body">

                <table class="table table-striped table-bordered">
                    <tbody>
                        
					<tr>
						<td width='30%' class='label-view text-right'>Id</td>
						<td>{{ $row->Id}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Username</td>
						<td>{{ $row->username}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Password</td>
						<td>{{ $row->password}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Fname</td>
						<td>{{ $row->fname}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Address</td>
						<td>{{ $row->address}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Email</td>
						<td>{{ $row->email}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Referedby</td>
						<td>{{ $row->referedby}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ipaddress</td>
						<td>{{ $row->ipaddress}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Mobile</td>
						<td>{{ $row->mobile}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Active</td>
						<td>{{ $row->active}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Doj</td>
						<td>{{ $row->doj}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Country</td>
						<td>{{ $row->country}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Tamount</td>
						<td>{{ $row->tamount}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Payment</td>
						<td>{{ $row->payment}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Signupcode</td>
						<td>{{ $row->signupcode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Level</td>
						<td>{{ $row->level}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Pcktaken</td>
						<td>{{ $row->pcktaken}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Launch</td>
						<td>{{ $row->launch}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Expiry</td>
						<td>{{ $row->expiry}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Bankname</td>
						<td>{{ $row->bankname}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Accountname</td>
						<td>{{ $row->accountname}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Accountno</td>
						<td>{{ $row->accountno}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Accounttype</td>
						<td>{{ $row->accounttype}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Ifsccode</td>
						<td>{{ $row->ifsccode}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Getpayment</td>
						<td>{{ $row->getpayment}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Renew</td>
						<td>{{ $row->renew}} </td>
						
					</tr>
				
					<tr>
						<td width='30%' class='label-view text-right'>Payoff</td>
						<td>{{ $row->payoff}} </td>
						
					</tr>
				
                    </tbody>
                </table>

                

            </div>
        </div>

    </div>
</div>

@stop