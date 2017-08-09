@extends('layouts.master') @section('content')

<div class="page-content">
    <!-- Page header -->
    <div class="page-content-wrapper m-t">
        
        {!! Form::open(array('url'=>'admin/{class}/save?return='.$return, 'class'=>'form-{form_display}','files' => true , 'data-parsley-validate'=>'')) !!} 
        <div class="portlet light bordered">
            <div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption">
                    {icon}<span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    <a href="{{ url('admin/{class}?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back"><i class="fa  fa-arrow-left"></i></a>
                </div>
            </div>
            <div class="portlet-body">

                @if (session('message'))
                    <div class="alert @if(session('status') == 'success') alert-success @else alert-danger @endif">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                        {{ session('message') }}
                    </div>
                @endif
                <div class="row">
                    @include('{class}.fields')
                </div>
                {subform}
                <hr>
                <div class="row">
                    <div class="form-actions">
                        <div class="col-md-offset-4 col-md-8">
                            <button type="submit" name="submit" class="btn green"><i class="fa fa-save"></i> Save</button>
                            <button type="submit" name="apply" value="apply" class="btn blue hidden-xs"><i class="fa fa-check-circle"></i> Apply Change(s)</button>
                            <button type="button" onclick="location.href='{{ URL::to('admin/{class}?return='.$return) }}' " class="btn btn-default"><i class="fa fa-close "></i> Cancel </button>
                        </div>

                    </div>
                </div>
               
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </div>
</div>
@section('script')
<script type="text/javascript">
    $(document).ready(function() {
        {masterdetailjs} 
        {form_javascript}
    });
</script>
@endsection
@stop