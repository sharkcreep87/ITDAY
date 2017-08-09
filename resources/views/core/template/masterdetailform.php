<?php

$tpl['masterdetailmodel'] = str_replace("/","","\$this->modelview = new  \App\Models\/".$module."();");
$tpl['masterdetaildelete'] = '\DB::table(\''.$info['table'].'\')->whereIn(\''.$info['key'].'\',$request->input(\'ids\'))->delete();';
$tpl['masterdetailform'] = '
<div class="row">
	<div class="col-sm-12 col-xs-12">		
		<hr />
		<div class="clr clear"></div>
		
		<h2> '.$info['title'].' </h2>
		
		<div class="table-responsive bulk-form">
		    <table class="table table-bordered table-hover detailview">
		        <thead>
					<tr>
						@foreach ($subform[\'tableGrid\'] as $t)
							@if($t[\'view\'] ==\'1\' && $t[\'field\'] !=\''.$info['master_key'].'\' && $t[\'field\'] !=\''.$info['key'].'\')
								<th align="{{$t[\'align\']}}" width="{{$t[\'width\']}}" @if($t[\'form\'][\'type\'] == \'auto_val\') class="hide" @endif>{{ $t[\'label\'] }}</th>
							@endif
						@endforeach
						<th></th>	
					  </tr>

		        </thead>

		        <tbody>
		        @if(count($subform[\'rowData\'])>=1)
		            @foreach ($subform[\'rowData\'] as $i=>$rows)
		            <tr class="clone clonedInput">
											
					 @foreach ($subform[\'tableGrid\'] as $field)
						 @if($field[\'view\'] ==\'1\' && $field[\'field\'] !=\''.$info['master_key'].'\' && $field[\'field\'] !=\''.$info['key'].'\')
						 <td @if($field[\'form\'][\'type\'] == \'auto_val\') class="hide" @endif>					 
						 	{!! SiteHelpers::bulkForm($field[\'field\'] , $field[\'form\'] , $i, $rows->{$field[\'field\']}) !!}							 
						 </td>
						 @endif					 
					 
					 @endforeach
					 <td>
					 	<input type="hidden" name=\'bulk_'.$info['primary_key'].'[{{$i}}]\' value=\'{{$rows->'.$info['primary_key'].'}}\'>
					 	<a onclick=" $(this).parents(\'.clonedInput\').remove(); return false" href="#" class="remove btn btn-sm btn-danger"><i class="fa fa-minus"></i></a>
					 	<input type="hidden" name="counter[{{$i}}]">
					 </td>
					@endforeach
					</tr> 

				@else
		            <tr class="clone clonedInput">
											
					 @foreach ($subform[\'tableGrid\'] as $field)

						 @if($field[\'view\'] ==\'1\' && $field[\'field\'] !=\''.$info['master_key'].'\' && $field[\'field\'] !=\''.$info['key'].'\')
						 <td @if($field[\'form\'][\'type\'] == \'auto_val\') class="hide" @endif>					 
						 	{!! SiteHelpers::bulkForm($field[\'field\'] , $field[\'form\'] ) !!}							 
						 </td>
						 @endif					 
					 
					 @endforeach
					 <td>
					 	<input type="hidden" name=\'bulk_'.$info['primary_key'].'[0]\'>
					 	<a onclick=" $(this).parents(\'.clonedInput\').remove(); return false" href="#" class="remove btn btn-sm btn-danger"><i class="fa fa-minus"></i></a>
					 	<input type="hidden" name="counter[0]">
					 </td>
					
					</tr> 

				
				@endif	


		        </tbody>	

		     </table>  
		     <input type="hidden" name="enable-masterdetail" value="true">
	    </div>
	     
	    <a href="javascript:void(0);" class="addC btn btn-sm btn-info" rel=".clone"><i class="fa fa-plus"></i> New Item</a>
	    <hr />
	</div>
</div>
';

$tpl['masterdetailview'] ='	<hr />
	
	<h5> '.$info['title'].' </h5>
	
	<div class="table-responsive">
    <table class="table table-striped ">
        <thead>
			<tr>
				<th class="number"> No </th>
					@foreach ($subgrid[\'tableGrid\'] as $t)
					@if($t[\'view\'] ==\'1\')
						<th>{{ $t[\'label\'] }}</th>
					@endif
				@endforeach
				
			  </tr>
        </thead>

        <tbody>
            @foreach ($subgrid[\'rowData\'] as $row)
            <tr>
				<td width="30">  </td>		
			 @foreach ($subgrid[\'tableGrid\'] as $field)
				 @if($field[\'view\'] ==\'1\' )		
				 	<td> {!! SiteHelpers::formatRows($row->$field[\'field\'],$field) !!}</td>				 
				 @endif					 
			 
			 @endforeach
			@endforeach
			</tr> 


        </tbody>	

     </table>   
     </div>';     

$tpl['masterdetailjs'] = '$(\'.addC\').relCopy({});';     
