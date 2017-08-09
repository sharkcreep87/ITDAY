@extends('layouts.system')
@section('style')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-form bordered">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-red"></i>
                        <span class="caption-subject font-red bold">Pages</span>
                    </div>
                    <div class="actions">
                        <a href="@if(count($pages) == 0) {{url('core/page/template')}} @else {{url('core/page/create')}} @endif" class="btn tips" title="Create New Page"><i class="fa fa-plus"></i> New Page</a>
                        <a href="javascript:;" class="btn tips" title="Import Page(s)" onclick="_Modal('{{url("core/page/import")}}', 'Import');"><i class="icon-cloud-upload"></i> Import</a>
                        <a href="javascript:;" class="btn tips" title="Export Page(s)" onclick="_Export('{{url("core/page/export")}}');"><i class="icon-cloud-download"></i> Export</a>
                        <a href="javascript:;" class="btn tips" title="Delete Page(s)" onclick="_Delete();"><i class="fa fa-remove"></i> Delete</a>
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('message'))
                        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ session('message') }}
                        </div>
                    @endif
                    <form action="{{url('core/page/destroy')}}" method="post" id="_Table">
                        {{csrf_field()}}
                        <div class="table-responsive min-height-500">
                            @if(count($pages) >=1)
                            <table class="table table-striped ">
                                <thead>
                                    <tr>
                                        <th class="icheck">
                                            <input type="checkbox" class="checkall" />
                                        </th>
                                        <th>Action</th>
                                        <th>Title</th>
                                        <th>Alias</th>
                                        <th>Method/Url</th>
                                        <th>Type</th>
                                        <th>Meta Title</th>
                                        <th>Created</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($pages as $row)
                                        <tr>
                                            <td class="icheck">
                                                <input type="checkbox" class="ids" name="ids[]" value="{{ $row->id }}" />
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button class="btn btn-sm green dropdown-toggle" data-toggle="dropdown">
                                                        <i class="icon-settings"></i> <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu icons-right">
                                                        <li>
                                                            <a target="_blank" href="{{url($row->url)}}"><i class="icon-eye"></i> View Page </a>
                                                        </li>
                                                        <li>
                                                            <a href="{{ url('core/page/'.$row->id.'/edit')}}"><i class="icon-note"></i> Edit Page</a>
                                                        </li>
                                                        <li class="divider"></li>
                                                        <li>
                                                            <a href="{{ url('core/page/'.$row->id.'/destroy')}}" onclick="return confirm('Are you sure want to delete this page?.');" class="font-red"><i class="icon-trash font-red"></i> Destory</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><a target="_blank" href="{{url($row->url)}}">{{$row->title}}</a></td>
                                            <td>{{$row->alias}}</td>
                                            <td><span class="uppercase">{{$row->method}}:</span> {{$row->url}}</td>
                                            <td>{{$row->type}}</td>
                                            <td>{{$row->meta_title}}</td>
                                            <td>{{date('d/m/Y', strtotime($row->created_at))}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
@endsection

