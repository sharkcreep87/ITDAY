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
                        <i class="fa fa-database font-red"></i>
                        <span class="caption-subject font-red bold">Database Tables</span>
                    </div>
                    <div class="actions">
                        <a href="{{url('core/table/create')}}" class="btn tips" title="Create New Table"><i class="fa fa-plus"></i> New Table </a>
                        <a href="javascript:;" class="btn tips" title="Create New View" onclick="_Modal('{{url("core/view")}}', 'Create View');"><i class="fa fa-plus"></i>  New View </a>
                        <a href="javascript:;" class="btn tips" title="Import SQL File" onclick="_Modal('{{url("core/table/import")}}', 'Import Table');"><i class="fa fa-upload"></i>  Import Table </a>
                        <a href="javascript:;" class="btn tips" title="Delete Table(s)" onclick="_Delete()"><i class="fa fa-remove"></i>  Delete </a>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            @if (session('message'))
                                <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                    {{ session('message') }}
                                </div>
                            @endif
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                        <p>{{ $error }}</p>
                                    @endforeach
                                </div>
                            @endif
                            <div class="tabbable-custom ">
                                <ul class="nav nav-tabs ">
                                    <li class="active">
                                        <a href="#tab_5_1" data-toggle="tab"> Manage Tables </a>
                                    </li>
                                    <li>
                                        <a href="#tab_5_2" data-toggle="tab"> Manage Views </a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane active" id="tab_5_1">
                                        <form action="{{url('core/table/delete')}}" method="post" id="_Table">
                                            {{csrf_field()}}
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th width="30" class="icheck">
                                                                <input type="checkbox" class="checkall" />
                                                            </th>
                                                            <th> Table Name </th>
                                                            <th> Engine </th>
                                                            <th> Collation </th>
                                                            <th> Data Rows </th>
                                                            <th> Create At </th>
                                                            <th> Action </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($tables as $tb)
                                                        @if($tb['info']->Engine != null)
                                                            <tr>
                                                                <td class="icheck">
                                                                    <input type="checkbox" class="ids" name="tables[]" value="{{ $tb['name'] }}" /> </td>
                                                                </td>
                                                                <td>
                                                                    {{ $tb['info']->Name }}
                                                                </td>
                                                                <td>
                                                                    {{ $tb['info']->Engine }}
                                                                </td>
                                                                <td>
                                                                    {{ $tb['info']->Collation }}
                                                                </td>
                                                                <td>
                                                                    {{ $tb['info']->Rows }}
                                                                </td>
                                                                <td>
                                                                    {{ $tb['info']->Create_time }}
                                                                </td>
                                                                <td>
                                                                    <a href="{{ url('core/table/'.$tb['name'].'/edit') }}" class="btn btn-xs green" ><i class="fa fa-edit "></i></a>
                                                                    <a href="{{ url('core/table/'.$tb['name'].'/remove') }}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                                                                </td>
                                                            </tr>
                                                        @endif
                                                        @endforeach
                                                    </tbody>

                                                </table>

                                            </div>
                                        </form>
                                        
                                    </div>
                                    <div class="tab-pane" id="tab_5_2">
                                        <div class="table-responsive">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th width="30">
                                                            No.
                                                        </th>
                                                        <th> View Name </th>
                                                        <th width="150"> Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @php $i = 1; @endphp
                                                    @foreach($tables as $tb)
                                                    @if($tb['info']->Engine == null)
                                                        <tr>
                                                            <td class="icheck">
                                                                {{$i}}
                                                            </td>
                                                            <td>
                                                                {{ $tb['info']->Name }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ url('core/view/'.$tb['name'].'/remove') }}" onclick="return confirm('Are you sure want to delete?');" class="btn btn-xs btn-danger"><i class="fa fa-minus"></i></a>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endif
                                                    @endforeach
                                                </tbody>

                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-margin margin-bottom-20">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection