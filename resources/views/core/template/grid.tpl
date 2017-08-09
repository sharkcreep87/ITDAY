@extends('layouts.master') @section('content') <?php usort($tableGrid, "SiteHelpers::_sort") ?>
<div class="page-content">

    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered">
        	<div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption hidden-xs">
                    {icon}<span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="grid actions">
                    @if($access['is_add'] ==1)
                    <a href="{{ url('admin/{class}/update?return='.$return) }}" class="tips btn btn-xs green" title="Create {{ $pageTitle }}">
                        <i class="fa  fa-plus "></i> <span class="hidden-xs">Create</span></a>
                    @endif @if($access['is_remove'] ==1)
                    <a href="javascript://ajax" onclick="_Delete();" class="tips btn btn-xs red" title="Delete {{ $pageTitle }}">
                        <i class="fa fa-trash-o"></i> <span class="hidden-xs">Delete</span></a>
                    @endif
                    <a href="javascript:;" class="tips btn btn-xs yellow-gold" onclick="_Modal('{{ url('admin/{class}/search?return='.$return) }}','Advance Search'); return false;" title="Search {{ $pageTitle }}"><i class="fa  fa-search"></i> <span class="hidden-xs">Search</span></a>
                    @if($access['is_excel'] ==1)
                    <a href="{{ url('admin/{class}/download?return='.$return) }}" class="tips btn btn-xs blue" title="Download {{ $pageTitle }}">
                        <i class="fa fa-cloud-download"></i> <span class="hidden-xs">Download</span></a>
                    @endif

                    <a href="{{ url('admin/{class}') }}" class=" tips btn btn-xs btn-default" title="Clear Search"><i class="fa fa-spinner"></i> <span class="hidden-xs"> Clear</span></a>
                </div>
            </div>

            <div class="portlet-body">
                @if (session('message'))
                    <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{ session('message') }}
                    </div>
                @endif
                @if(count($rowData) >= 1)

                {!! (isset($search_map) ? $search_map : '') !!} 
                {!! Form::open(array('url'=>'admin/{class}/delete/0?return='.$return, 'class'=>'form-horizontal' ,'id' =>'_Table' )) !!}
                <div class="table-responsive tb_body">
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <th class="number"><span> No </span> </th>
                                <th class="icheck">
                                    <input type="checkbox" class="checkall" />
                                </th>
                                <th><span>Action</span></th>

                                @foreach ($tableGrid as $t) @if($t['view'] =='1')
                                <?php $limited = isset($t['limited']) ? $t['limited'] :''; ?>
                                    @if(SiteHelpers::filterColumn($limited ))

                                    <th @if(isset($t['width']) && $t['width'] != 'auto') width="{{$t['width']}}" @endif  align="{{$t['align']}}"><span>{{ $t['label'] }}</span></th>
                                    @endif @endif @endforeach

                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($rowData as $row)
                            <tr>
                                <td width="30"> {{ ++$i }} </td>
                                <td width="50" class="icheck">
                                    <input type="checkbox" class="ids" name="ids[]" value="{{ $row->{key} }}" /> </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn red btn-xs dropdown-toggle" type="button" data-toggle="dropdown"> <i class="fa fa-cog"></i>
                                            <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                            @if($access['is_detail'] ==1)
                                            <li><a href="{{ url('admin/{class}/show/'.$row->{key}.'?return='.$return)}}" class="tips" title="View"><i class="fa  fa-search "></i> View </a></li>
                                            @endif @if($access['is_edit'] ==1)
                                            <li><a href="{{ url('admin/{class}/update/'.$row->{key}.'?return='.$return) }}" class="tips" title="Edit"><i class="fa fa-edit "></i> Edit </a></li>
                                            @endif
                                        </ul>
                                    </div>

                                </td>

                                @foreach ($tableGrid as $field) @if($field['view'] =='1')
                                <?php $limited = isset($field['limited']) ? $field['limited'] :''; ?>
                                    @if(SiteHelpers::filterColumn($limited ))
                                    <td @if(isset($field['width']) && $field['width'] != 'auto') width="{{$field['width']}}" @endif align="{{$field['align']}}">
                                        {!! SiteHelpers::formatRows($row->{$field['field']},$field ,$row ) !!}
                                    </td>
                                    @endif @endif @endforeach
                            </tr>

                            @endforeach

                        </tbody>

                    </table>
                    <input type="hidden" name="md" value="" />
                </div>
                {!! Form::close() !!} @include('footer')
                @else
                    <p class="text-center image_background no-result">There is no record!
                        <br />
                        <br />
                        <a href="{{ url('admin/{class}/update?return='.$return) }}" class="btn btn-danger "><i class="icon-plus-circle2"></i> New {{ $pageTitle }} </a>
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>

@stop