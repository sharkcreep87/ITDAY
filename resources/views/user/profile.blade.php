@extends('layouts.system')
@section('style')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ asset('apitoolz-assets/css/profile.min.css')}}" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('content')
<!-- BEGIN CONTENT BODY -->
<div class="page-content">
    <!-- BEGIN PAGE HEAD-->
    <div class="page-head">
        <!-- BEGIN PAGE TITLE -->
        <div class="page-title">
            <h1 class="uppercase">User
                <small>Manage Profile</small>
            </h1>
        </div>
        <!-- END PAGE TITLE -->
    </div>
    <!-- END PAGE HEAD-->
    <div class="row">
        <div class="col-md-12">
            <!-- BEGIN VALIDATION STATES-->
            <div class="portlet light portlet-form bordered">
                <div class="portlet-body">
                    <div class="row">
                        <div class="col-md-12">
                            <!-- BEGIN PROFILE SIDEBAR -->
                            <div class="profile-sidebar">
                                <!-- PORTLET MAIN -->
                                <div class="portlet light profile-sidebar-portlet bordered">
                                    <!-- SIDEBAR USERPIC -->
                                    <div class="profile-userpic text-center">
                                        {!!SiteHelpers::avatar(150)!!}
                                    </div>
                                    <!-- END SIDEBAR USERPIC -->
                                    <!-- SIDEBAR USER TITLE -->
                                    <div class="profile-usertitle">
                                        <div class="profile-usertitle-name font-red"> {{$user->first_name}} {{$user->last_name}}</div>
                                        <div class=""> {{$user->email}} </div>
                                    </div>
                                    <!-- END SIDEBAR USER TITLE -->
                                    <!-- SIDEBAR MENU -->
                                    <div class="profile-usermenu">
                                        <ul class="nav">
                                            <li class="@if(Request::segment(2)== 'profile') active @endif ">
                                                <a href="{{url('user/profile')}}">
                                                    <i class="icon-screen-desktop"></i> Dashboard </a>
                                            </li>
                                            <li class="">
                                                <a href="{{url('core/settings/general')}}">
                                                    <i class="icon-settings"></i> Settings </a>
                                            </li>

                                            <li class="">
                                                <a href="{{url('core/settings/security')}}">
                                                    <i class="icon-key"></i> Security 
                                                </a>
                                            </li>
                                            <li class="">
                                                <a href="{{url('user/logout')}}">
                                                    <i class="icon-logout"></i> Logout 
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!-- END MENU -->
                                </div>
                                <!-- END PORTLET MAIN -->
                            </div>
                            <!-- END BEGIN PROFILE SIDEBAR -->
                            <div class="profile-content">
                                <div class="portlet light bordered">
                                    <div class="portlet-title tabbable-line">
                                        <div class="caption caption-md">
                                            <i class="icon-globe theme-font hide"></i>
                                            <span class="caption-subject font-red bold">Profile</span>
                                        </div>
                                        <ul class="nav nav-tabs">
                                            <li class="active">
                                                <a href="#tab_1_1" data-toggle="tab"><i class="icon-user"></i> Personal Info</a>
                                            </li>
                                            <li>
                                                <a href="#tab_1_3" data-toggle="tab"><i class="icon-key"></i> Change Password</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="tab-content">
                                            <!-- PERSONAL INFO TAB -->
                                            <div class="tab-pane active" id="tab_1_1">
                                                @if (session('message'))
                                                    <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                                                        {{ session('message') }}
                                                    </div>
                                                @endif
                                                <form action="{{url('user/profile/'.$user->id)}}" method="post" enctype="multipart/form-data">
                                                    {{csrf_field()}}
                                                    <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                                                        <label class="control-label"> Username </label>
                                                        <input name="username" type="text" id="username" disabled="disabled" class="form-control" required value="{{ $user->username }}" />
                                                        @if ($errors->has('username'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('username') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                                        <label class="control-label"> Email </label>
                                                        <input name="email" type="text" id="email" class="form-control " value="{{ $user->email }}"/>
                                                        @if ($errors->has('email'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('email') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="form-group {{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                        <label class="control-label"> First name </label>
                                                        <input name="first_name" type="text" id="first_name" class="form-control" required value="{{ $user->first_name }}" />
                                                        @if ($errors->has('first_name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('first_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                        <label class="control-label"> Last name </label>
                                                        <input name="last_name" type="text" id="last_name" class="form-control" required value="{{ $user->last_name }}" />
                                                        @if ($errors->has('last_name'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('last_name') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group {{ $errors->has('avatar') ? ' has-error' : '' }}">
                                                        <label class="control-label"> Avatar </label>
                                                        <input type="file" name="avatar"> Image Dimension 80 x 80 px
                                                        <br /> 
                                                        @if($user->avatar)
                                                        <img src="{{asset('uploads/users/'.$user->avatar)}}" width="80px" height="80px">
                                                        @endif
                                                        <br>
                                                        @if ($errors->has('avatar'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('avatar') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="margiv-top-10">
                                                        <button class="btn btn-success green" type="submit">Save changes</button>
                                                    </div>

                                                </form>
                                            </div>
                                            <!-- END PERSONAL INFO TAB -->
                                            <!-- CHANGE PASSWORD TAB -->
                                            <div class="tab-pane" id="tab_1_3">
                                                <form action="{{url('user/password/'.$user->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                                        <label class="control-label"> New Password </label>
                                                        <input name="password" type="password" id="password" class="form-control input-sm" value="" />
                                                        @if ($errors->has('password'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                                        <label class="control-label"> Confirm Password </label>
                                                        <input name="password_confirmation" type="password" id="password_confirmation" class="form-control input-sm" value="" />
                                                        @if ($errors->has('password_confirmation'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>

                                                    <div class="margin-top-10">
                                                        <button class="btn btn-danger" type="submit">Save changes</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <!-- END CHANGE PASSWORD TAB -->
                                        </div>
                                    </div>
                                </div>
                            </div>
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
@section('plugin')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
@endsection
@section('script')
@endsection

