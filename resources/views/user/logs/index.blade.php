@extends('layouts.master')
 @section('content') <?php usort($tableGrid, "SiteHelpers::_sort") ?>
<div class="page-content">
    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered animated fadeInUp">
            <div class="portlet-title">

            	@if(isset($pageTitle) && isset($pageAction))
                <div class="caption hidden-xs">
                    <span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    @if($access['is_remove'] ==1)
                    <a href="javascript://ajax" onclick="_Delete();" class="tips btn btn-xs red" title="Delete">
                        <i class="fa fa-trash-o"></i> <span class="hidden-xs">Delete</span></a>
                    @endif
                    @if($access['is_excel'] ==1)
                    <a href="{{ URL::to('user/logs/download?return='.$return) }}" class="tips btn btn-xs blue" title="Download">
                        <i class="fa fa-cloud-download"></i> <span class="hidden-xs">Download</span></a>
                    @endif
                </div>
            </div>
            <div class="portlet-body">

                {!! Form::open(array('url'=>'user/logs/delete/', 'class'=>'form-horizontal' ,'id' =>'_Table' )) !!}
                <div class="table-responsive" style="min-height:300px;">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>
                                <th class="icheck">
                                    <input type="checkbox" class="checkall" />
                                </th>

                                @foreach ($tableGrid as $t) @if($t['view'] =='1')
                                <th>{{ $t['label'] }}</th>
                                @endif @endforeach
                                <th width="70">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($rowData as $row)
                            <tr>
                                <td width="30"> {{ ++$i }} </td>
                                <td width="50" class="icheck">
                                    <input type="checkbox" class="ids" name="id[]" value="{{ $row->auditID }}" /> </td>
                                @foreach ($tableGrid as $field) 
                                    @if($field['view'] =='1')
                                    <td>
                                       {!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!} 
                                    </td>
                                    @endif 
                                @endforeach
                                <td>
                                    @if($access['is_detail'] ==1)
                                    <a href="{{ URL::to('user/logs/show/'.$row->auditID.'?return='.$return)}}" class="tips btn btn-xs btn-white" title="View"><i class="fa  fa-search "></i></a> @endif @if($access['is_edit'] ==1)
                                    <a href="{{ URL::to('user/logs/update/'.$row->auditID.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="Edit"><i class="fa fa-edit "></i></a> @endif

                                </td>
                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                    <input type="hidden" name="md" value="" />
                </div>
                {!! Form::close() !!} @include('footer')
            </div>
        </div>
    </div>
</div>
@section('page_scripts')
<script>
    $(document).ready(function() {

        $('.do-quick-search').click(function() {
            $('#SximoTable').attr('action', '{{ URL::to("logs/multisearch")}}');
            $('#SximoTable').submit();
        });

    });
</script>
@endsection
@stop