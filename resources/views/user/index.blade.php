@extends('layouts.master') @section('content')
<?php usort($tableGrid, "SiteHelpers::_sort") ?>
    <div class="page-content">
        <div class="portlet light bordered">
            <div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption hidden-xs">
                    <i class="icon-user font-red"></i>
                    <span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    @if($access['is_add'] ==1)
                    <a href="{{ url('user/update?return='.$return) }}" class="tips btn btn-xs green" title="Create">
                        <i class="fa  fa-plus "></i> <span class="hidden-xs">Create</span></a>
                    @endif @if($access['is_remove'] ==1)
                    <a href="javascript://ajax" onclick="_Delete();" class="tips btn btn-xs red" title="Delete">
                        <i class="fa fa-trash-o"></i> <span class="hidden-xs">Delete</span></a>
                    @endif
                    <a href="{{ url('user/search?return='.$return) }}" class="tips btn btn-xs yellow-gold" onclick="_Modal(this.href,'Advance Search'); return false;" title="Search"><i class="fa  fa-search"></i> <span class="hidden-xs">Search</span></a>
                    @if($access['is_excel'] ==1)
                    <a href="{{ url('user/download?return='.$return) }}" class="tips btn btn-xs blue" title="Download">
                        <i class="fa fa-cloud-download"></i> <span class="hidden-xs">Download</span></a>
                    @endif
                    <a href="{{ url('user') }}" class=" tips btn btn-xs default" title="Clear"><i class="fa fa-spinner"></i> <span class="hidden-xs"> Clear</span></a>
                </div>
            </div>

            <div class="portlet-body">
                {!! Form::open(array('url'=>'user/delete/', 'class'=>'form-horizontal' ,'id' =>'_Table' )) !!}
                <div class="table-responsive" style="min-height:300px;">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"> No </th>
                                <th class="icheck">
                                    <input type="checkbox" class="checkall" />
                                </th>

                                @foreach ($tableGrid as $t) 
                                    @if($t['view'] =='1' && $t['field'] != 'remember_token' && $t['field'] != 'reminder')
                                    <th>{{ $t['label'] }}</th>
                                    @endif 
                                @endforeach
                                <th width="100">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach ($rowData as $row)
                            <tr>
                                <td width="30"> {{ ++$i }} </td>
                                <td width="50" class="icheck">
                                    <input type="checkbox" class="ids" name="ids[]" value="{{ $row->id }}" /> </td>
                                @foreach ($tableGrid as $field) 
                                    @if($field['view'] =='1' && $field['field'] != 'remember_token' && $field['field'] != 'reminder')
                                    <td>
                                        @if($field['field'] == 'avatar')
                                            <?php if( file_exists( './uploads/users/'.$row->avatar) && $row->avatar !='') { ?>
                                            <img src="{{ url('uploads/users').'/'.$row->avatar }} " border="0" width="40" class="img-circle" />
                                            <?php  } else { ?>
                                                <img alt="" src="https://www.gravatar.com/avatar/{{ md5($row->email) }}" width="40" class="img-circle" />
                                            <?php } ?>
                                        @elseif($field['field'] =='active') {!! ($row->active ==1 ? '
                                                <lable class="label label-success">Active</label>' : '
                                                    <lable class="label label-danger">Inactive</label>') !!} 
                                        @else
                                            {!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!} 
                                        @endif
                                    </td>
                                    @endif 
                                @endforeach
                                <td>
                                    @if($access['is_detail'] ==1)
                                    <a href="{{ url('user/show/'.$row->id.'?return='.$return)}}" class="tips btn btn-xs btn-white" title="View"><i class="fa  fa-search "></i></a> 
                                    @endif @if($access['is_edit'] ==1)
                                    <a href="{{ url('user/update/'.$row->id.'?return='.$return) }}" class="tips btn btn-xs btn-white" title="Edit"><i class="fa fa-edit "></i></a> 
                                    @endif

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
    @section('page_scripts')
    <script>
        $(document).ready(function() {

            $('.do-quick-search').click(function() {
                $('#SximoTable').attr('action', '{{ url("user/multisearch")}}');
                $('#SximoTable').submit();
            });

        });
    </script>
    @endsection @stop