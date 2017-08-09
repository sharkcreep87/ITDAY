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
                        <span class="caption-subject font-red bold">Security Settings</span>
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
                    {!! Form::open(array('url'=>'core/settings/security', 'class'=>'form-horizontal','data-parsley-validate'=>'', 'files' => true)) !!}
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Mail System </label>
                                <div class="col-sm-8 mail icheck">

                                    <label class="radio">
                                        <input type="radio" name="cnf_mail" value="phpmail" @if(env('APP_MAIL')=='phpmail' ) checked @endif /> PHP MAIL System
                                    </label>

                                    <label class="radio">
                                        <input type="radio" name="cnf_mail" value="swift" @if(env('APP_MAIL')=='swift' ) checked @endif /> SWIFT Mail <a data-toggle="modal" href="#draggable"> ( Required Configuration ) </a>
                                    </label>

                                    
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Default Group Registration </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="cnf_group">
                                        @foreach($groups as $group)
                                        <option value="{{ $group->group_id }}" @if(env('APP_GROUP')==$group->group_id ) selected @endif >{{ $group->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Redirect Module </label>
                                <div class="col-sm-8">
                                    <select class="form-control" name="cnf_redirect">
                                        <option value="dashboard">Dashboard</option>
                                        @foreach($modules as $row)
                                        <option value="{{ $row->module_name }}" @if(env('APP_REDIRECT')==$row->module_name ) selected @endif >{{ $row->module_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4">Registration Setting</label>
                                <div class="col-sm-8 icheck">

                                    <label class="radio">
                                        <input type="radio" name="cnf_activation" value="auto" @if(env('APP_ACTIVATION')=='auto' ) checked @endif /> Automatic activation
                                    </label>

                                    <label class="radio">
                                        <input type="radio" name="cnf_activation" value="manual" @if(env('APP_ACTIVATION')=='manual' ) checked @endif /> Manual activation
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="cnf_activation" value="confirmation" @if(env('APP_ACTIVATION')=='confirmation' ) checked @endif/> Email with activation link
                                    </label>

                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Allow Registration </label>
                                <div class="col-sm-8 margin-top-10 icheck">
                                    <label class="checkbox">
                                        <input type="checkbox" name="cnf_regist" value="true" @if(env('APP_REGIST')=='true' ) checked @endif/> Enable
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="col-sm-12 text-left">Blocked IP Address <small> Restric IP Address</small> </label>

                                <p class="col-sm-12 text-left"><small><i>
                                    Write spesific IP address restriced for access this app  <br />
                                    Example : <code> 192.116.134 , 194.111.606.21 </code>
                                </i></small>
                                </p>
                                <div class="col-sm-12">
                                    <textarea rows="5" class="form-control" name="cnf_allowip">{{ env('APP_RESTRICIP') }}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-12 text-left"> Allowed IP Address </label>
                                <p class="col-sm-12 text-left"><small><i>
                                    Write spesific IP address Allowed for access this app  <br />
                                    Example : <code> 192.116.134 , 194.111.606.21 </code>
                                </i></small></p>
                                <div class="col-sm-12">
                                    <textarea rows="5" class="form-control col-sm-12" name="cnf_restricip">{{ env('APP_ALLOWIP') }}</textarea>
                                </div>
                            </div>

                            <p class="col-sm-12 text-left"> If Allowed IP is not empty then it will be priority and ingnored RESTRICED IP </p>

                        </div>
                        <div class="modal fade draggable-modal" id="draggable" tabindex="-1" role="basic" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h4 class="modal-title">Mail Configuration</h4>
                                    </div>
                                    <div class="modal-body">

                                        <div class="portlet light">
                                            <div class="portlet-body">
                                                <div class="form-vertical">
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL DRIVER</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_driver" value="{{ env('MAIL_DRIVER') }}"> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL HOST</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_mailhost" value="{{env('MAIL_HOST')}}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL PORT</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_mailport" value="{{ env('MAIL_PORT') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL USERNAME</label>
                                                        <div class="col-md-9">
                                                            <input type="email" class="col-md-9 form-control" name="cnf_mailusername" value="{{ env('MAIL_USERNAME') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL PASSWORD</label>
                                                        <div class="col-md-9">
                                                            <input type="password" class="col-md-9 form-control" name="cnf_mailpassword" value="{{ env('MAIL_PASSWORD') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL ENCRYPTION</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_mailencryption" value="{{ env('MAIL_ENCRYPTION') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL FROM ADDRESS</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_mailfromaddress" value="{{ env('MAIL_FROM_ADDRESS') }}">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-md-3 control-label">MAIL FROM NAME</label>
                                                        <div class="col-md-9">
                                                            <input type="text" class="col-md-9 form-control" name="cnf_mailfromname" value="{{ env('MAIL_FROM_NAME') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn green">Save changes</button>
                                    </div>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit">Save changes </button>
                                    <a href="{{url()->previous()}}" class="btn btn-default" type="submit"> Cancel </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">&nbsp;</div>
                    </div>
                    {!! Form::close() !!}
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

