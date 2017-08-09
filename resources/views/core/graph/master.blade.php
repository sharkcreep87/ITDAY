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
            <div class="portlet light bordered">
                <div class="portlet-title tabbable-line">
                    <div class="caption caption-md">
                        <i class="icon-graph font-red"></i>
                        <span class="caption-subject font-red bold">Graph APIs</span>
                    </div>
                    <div class="actions">
                                        
                    </div>
                </div>
                <div class="portlet-body">
                    @if (session('message'))
                        <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                            {{ session('message') }}
                        </div>
                    @endif
                    <ul class="nav nav-tabs margin-top-10">
                        <li class="@if(Request::segment(4)== 'index') active @endif"><a href="{{url('core/graph/'.$row->module_id.'/index')}}" >List {{$row->module_name}} </a></li>
                        <li class="@if(Request::segment(4)== 'create') active @endif"><a href="{{url('core/graph/'.$row->module_id.'/create')}}" >Create {{$row->module_name}} </a></li>
                        <li class="@if(Request::segment(4)== 'show') active @endif"><a href="{{url('core/graph/'.$row->module_id.'/show')}}" >Retrieve {{$row->module_name}}</a></li>
                        <li class="@if(Request::segment(4)== 'update') active @endif"><a href="{{url('core/graph/'.$row->module_id.'/update')}}" >Update {{$row->module_name}}</a></li>
                        <li class="@if(Request::segment(4)== 'destroy') active @endif"><a href="{{url('core/graph/'.$row->module_id.'/destroy')}}" >Delete {{$row->module_name}}</a></li>
                    </ul>
                    <div class="tab-content">
                        <!-- INDEX -->
                        <div class="tab-pane @if(Request::segment(4)== 'index') active @endif">
                            @yield('index')
                        </div>
                        <!-- END INDEX -->
                        <!-- CREATE -->
                        <div class="tab-pane @if(Request::segment(4)== 'create') active @endif">
                            @yield('create')
                        </div>
                        <!-- END CREATE -->
                        <!-- SHOW -->
                        <div class="tab-pane @if(Request::segment(4)== 'show') active @endif">
                            @yield('show')
                        </div>
                        <!-- END SHOW -->
                        <!-- UPDATE -->
                        <div class="tab-pane @if(Request::segment(4)== 'update') active @endif">
                            @yield('update')
                        </div>
                        <!-- END UPDATE -->
                        <!-- DESTROY -->
                        <div class="tab-pane @if(Request::segment(4)== 'destroy') active @endif">
                            @yield('destroy')
                        </div>
                        <!-- END DESTROY -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection