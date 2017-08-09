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
                        <i class="icon-settings font-red"></i>
                        <span class="caption-subject font-red bold">Configuration</span>
                    </div>
                    <ul class="nav nav-tabs">
                        <li class="@if(Request::segment(5)== 'info') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/info')}}"><i class="icon-bulb"></i> Basic Info</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'sql') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/sql')}}"><i class="fa fa-database"></i> SQL</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'table') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/table')}}"><i class="fa fa-list"></i> Table</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'form' || Request::segment(5)== 'subform' || Request::segment(5)== 'formdesign') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/form')}}"><i class="icon-note"></i> Form</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'relation') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/relation')}}"><i class="fa fa-link"></i> Relation</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'permission') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/permission')}}"><i class="icon-lock-open"></i> Permission</a>
                        </li>
                        <li class="@if(Request::segment(5)== 'email' || Request::segment(5)== 'sms') active @endif">
                            <a href="{{url('core/model/config/'.$row->module_id.'/email')}}"><i class="icon-envelope-open"></i> Notification</a>
                        </li>
                    </ul>
                </div>
                <div class="portlet-body">
                    <div class="tab-content">
                        @if (session('message'))
                            <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                {{ session('message') }}
                            </div>
                        @endif
                        <!-- INFO TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'info') active @endif" id="tab_1_1">
                            @yield('info')
                        </div>
                        <!-- END INFO TAB -->
                        <!-- SQL TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'sql') active @endif" id="tab_1_2">
                            @yield('sql')
                        </div>
                        <!-- END SQL TAB -->
                        <!-- TABLE TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'table') active @endif" id="tab_1_3">
                            @yield('table')
                        </div>
                        <!-- END TABLE TAB -->
                        <!-- FORM TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'form' || Request::segment(5)== 'subform' || Request::segment(5)== 'formdesign') active @endif" id="tab_1_4">
                            <div class="portlet light portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject"><strong>{{$row->module_title}} Form</strong> (Change form settings of Model )</span>
                                    </div>
                                    <div class="actions">
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs margin-top-10">
                                        <li class="@if(Request::segment(5)== 'form') active @endif"><a href="{{url('core/model/config/'.$row->module_id.'/form')}}" >Form Configuration </a></li>
                                        <li class="@if(Request::segment(5)== 'subform') active @endif"><a href="{{url('core/model/config/'.$row->module_id.'/subform')}}" >Sub Form </a></li>
                                        <li class="@if(Request::segment(5)== 'formdesign') active @endif"><a href="{{url('core/model/config/'.$row->module_id.'/formdesign')}}" >Form Layout</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <!-- FORM CONFIGURATION -->
                                        <div class="tab-pane @if(Request::segment(5)== 'form') active @endif" id="tab_2_1">
                                            @yield('form')
                                        </div>
                                        <!-- END FORM CONFIGURATION -->
                                        <!-- SUB FORM -->
                                        <div class="tab-pane @if(Request::segment(5)== 'subform') active @endif" id="tab_2_2">
                                            @yield('subform')
                                        </div>
                                        <!-- END SUB FORM -->
                                        <!-- FORM LAYOUT -->
                                        <div class="tab-pane @if(Request::segment(5)== 'formdesign') active @endif" id="tab_2_3">
                                            @yield('formdesign')
                                        </div>
                                        <!-- END FORM LAYOUT -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END FORM TAB -->
                        <!-- RELATION TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'relation') active @endif" id="tab_1_5">
                            @yield('relation')
                        </div>
                        <!-- END RELATION TAB -->
                        <!-- PERMISSION TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'permission') active @endif" id="tab_1_6">
                            @yield('permission')
                        </div>
                        <!-- END PERMISSION TAB -->
                        <!-- NOTIFI TAB -->
                        <div class="tab-pane @if(Request::segment(5)== 'email' || Request::segment(5)== 'sms') active @endif" id="tab_1_7">
                            <div class="portlet light portlet-form bordered">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <span class="caption-subject"><strong>{{$row->module_title}} Notification</strong></span>
                                    </div>
                                    <div class="actions">
                                        
                                    </div>
                                </div>
                                <div class="portlet-body">
                                    <ul class="nav nav-tabs margin-top-10">
                                        <li class="@if(Request::segment(5)== 'email') active @endif"><a href="{{url('core/model/config/'.$row->module_id.'/email')}}" >Email Notification</a></li>
                                        <!-- <li class="@if(Request::segment(5)== 'sms') active @endif"><a href="{{url('core/model/config/'.$row->module_id.'/sms')}}" >SMS</a></li> -->
                                    </ul>
                                    <div class="tab-content">
                                        <!-- EMAIL -->
                                        <div class="tab-pane @if(Request::segment(5)== 'email') active @endif" id="tab_3_1">
                                            @yield('email')
                                        </div>
                                        <!-- END EMAIL -->
                                        <!-- SUB SMS -->
                                        <!-- <div class="tab-pane @if(Request::segment(5)== 'sms') active @endif" id="tab_3_2">
                                            @yield('sms')
                                        </div> -->
                                        <!-- END SUB SMS -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END NOTIFI TAB -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection