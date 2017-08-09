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
                        <span class="caption-subject font-red bold">General Settings</span>
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
                    {!! Form::open(array('url'=>'core/settings/general', 'class'=>'form-horizontal','data-parsley-validate'=>'', 'files' => true)) !!}
                    <div class="row">
                        
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Domain</label>
                                <div class="col-md-8">
                                    <input name="cnf_domain" type="text" id="cnf_domain" class="form-control " required value="{{env('APP_URL')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Application Name</label>
                                <div class="col-md-8">
                                    <input name="cnf_appname" type="text" id="cnf_appname" class="form-control " required value="{{env('APP_NAME')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Application Description</label>
                                <div class="col-md-8">
                                    <textarea name="cnf_appdesc" rows="5" type="text" id="cnf_appdesc" class="form-control">{{env('APP_DESC')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Company Name</label>
                                <div class="col-md-8">
                                    <input name="cnf_comname" type="text" id="cnf_comname" class="form-control " value="{{env('APP_COMNAME')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">System Email</label>
                                <div class="col-md-8">
                                    <input name="cnf_email" type="text" id="cnf_email" class="form-control " value="{{env('APP_EMAIL')}}" />
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Time Zone </label>
                                <div class="col-md-8">
                                    <select class="form-control select2" name="cnf_timezone">
                                    @foreach($itemzone as $zone)
                                        <option value="{{$zone}}" @if($zone == env('APP_TIME')) selected @endif>{{$zone}}</option>
                                    @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Google Analytic View ID</label>
                                <div class="col-md-8">
                                    <input name="analytic_view_id" type="text" id="cnf_email" class="form-control " value="{{env('ANALYTICS_VIEW_ID')}}" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class=" control-label col-md-4">Google Analytic View File</label>
                                <div class="col-md-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="analytic_view_file"> 
                                        </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    {{env('ANALYTICS_VIEW_FILE')}}
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">Metakey </label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="5" name="cnf_metakey">{{env('APP_METAKEY')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label col-md-4">Meta Description</label>
                                <div class="col-md-8">
                                    <textarea class="form-control" rows="5" name="cnf_metadesc">{{env('APP_METADESC')}}</textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class=" control-label col-md-4">Backend Logo</label>
                                <div class="col-md-8">
                                    <div class="fileinput fileinput-new" data-provides="fileinput">
                                        <span class="btn green btn-file">
                                            <span class="fileinput-new"> Select file </span>
                                            <span class="fileinput-exists"> Change </span>
                                            <input type="file" name="logo"> </span>
                                        <span class="fileinput-filename"> </span> &nbsp;
                                        <a href="javascript:;" class="close fileinput-exists" data-dismiss="fileinput"> </a>
                                    </div>
                                    <p> <i>Please use image dimension 150px * 25px </i> </p>
                                    <div class="logo-placeholder">
                                        @if(file_exists(public_path().'/uploads/'.env('APP_LOGO')) && env('APP_LOGO') !='')
                                        <img src="{{ asset('uploads/'.env('APP_LOGO'))}}" alt="{{ env('APP_NAME') }}" /> 
                                        @else
                                        <img src="{{ asset('uploads/backend-logo.png')}}" alt="{{ env('APP_NAME') }}" /> 
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="ipt" class=" control-label col-md-4">&nbsp;</label>
                                <div class="col-md-8">
                                    <button class="btn green" type="submit">Save changes </button>
                                    <a href="{{url()->previous()}}" class="btn btn-default" type="submit">Cancel</a>
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

