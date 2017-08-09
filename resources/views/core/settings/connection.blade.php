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
                        <span class="caption-subject font-red bold">SSH Remote Connection</span>
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
                    {!! Form::open(array('url'=>'core/settings/connection', 'class'=>'form-horizontal','data-parsley-validate'=>'', 'files' => true)) !!}
                    <div class="row">
                        
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Host IP </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_host" value="{{env('REMOTE_HOST')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Username </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_username" value="{{env('REMOTE_USERNAME')}}" />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Password </label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="cnf_remote_password" value="{{env('REMOTE_PASSWORD')}}" />
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4">Remote SSH Key File</label>
                                <div class="col-sm-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="cnf_remote_key"> 
                                        </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    {{env('REMOTE_KEY')}}
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Key Text </label>
                                <div class="col-sm-8">
                                    <textarea class="form-control" name="cnf_remote_keytext" rows="5">{{env('REMOTE_KEYTEXT')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Keyphrase</label>
                                <div class="col-sm-8">
                                    <input type="password" class="form-control" name="cnf_remote_keyphrase" value="{{env('REMOTE_KEYPHRASE')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Agent </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_agent" value="{{env('REMOTE_AGENT')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-sm-4"> Remote Timeout </label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" name="cnf_remote_timeout" value="{{env('REMOTE_TIMEOUT')}}" />
                                </div>
                            </div>

                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit">Save changes </button>
                                    <a href="{{url()->previous()}}" class="btn btn-default" type="submit"> Cancel </a>
                                </div>
                            </div>
                        </div>
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

