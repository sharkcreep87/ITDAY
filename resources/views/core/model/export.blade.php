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
                        <span class="caption-subject font-red bold">Export Models</span>
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
                    {!! Form::open(array('url'=>'core/model/doexport', 'class'=>'form-vertical','files' => true , 'parsley-validate'=>'','novalidate'=>' ')) !!}
                        <div class="form-group  "  >
                          <label for="Module Id" class=" control-label  text-left">Additional SQL statement </label>
                          <div class="">
                            {!! Form::textarea('sql_cmd', '',array('class'=>'form-control', 'placeholder'=>'Copy SQL statement from PHPMyAdmin and paste here',  'rows' => 5 )) !!} 
                           </div> 
                        </div>

                        <div class="form-group  " >
                          <label for="Module Id" class=" control-label  text-left"> Upload additional SQL statement file.</label>
                          
                            {!! Form::file('sql_file', '',array('class'=>'form-control', 'placeholder'=>'Enter SQL Statement',   )) !!} 
                         
                        </div> 

                        <div class="form-group  "  >
                          <label for="Module Id" class=" control-label  text-left"> Your additional include path/file(s)</label>
                          <div class="">
                            {!! Form::textarea('inc_paths', '',array('class'=>'form-control', 'placeholder'=>'For multiple include path/file(s), you can use " , ". And then make sure with "/" in end of path.',  'rows' => 5 )) !!} 
                           </div> 
                        </div>
                        <hr>  
                        <div class="form-group">
                          <button type="submit" class="btn btn-primary "> Export </button>
                          <a href="{{url('core/model')}}" class="btn btn-success "> Cancel </a>
                        </div> 
                        <input type="hidden" name="ids" value="{{$enc_id}}">
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

