@extends('layouts.master') @section('content')

<div class="page-content">

    <div class="page-content-wrapper">

        {!! Form::open(array('url'=>'user/groups/save?return='.$return, 'class'=>'form-horizontal','files' => true , 'data-parsley-validate'=>'')) !!}
        @if(count($errors->all()) > 0)
        <div class="note note-danger">
            @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
            @endforeach
        </div>
        @endif
        <div class="portlet light bordered">
            
			<div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption">
                    <span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    
                </div>
            </div>                
            <div class="portlet-body row">

                <div class="form col-xs-12 col-md-12">
                    {!! Form::hidden('group_id', $row['group_id'],array('class'=>'form-control', 'placeholder'=>'', )) !!}
                    <div class="form-group  ">
                        <label for="Name" class=" col-xs-12 control-label col-md-4 text-left"> Name <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            {!! Form::text('name', $row['name'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )) !!}
                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Description" class=" col-xs-12 control-label col-md-4 text-left"> Description </label>
                        <div class="col-xs-12 col-md-6">
                            <textarea name='description' rows='2' id='description' class='form-control '>{{ $row['description'] }}</textarea>
                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <div class="form-group  ">
                        <label for="Level" class=" col-xs-12 control-label col-md-4 text-left"> Level <span class="asterix"> * </span></label>
                        <div class="col-xs-12 col-md-6">
                            {!! Form::text('level', $row['level'],array('class'=>'form-control', 'placeholder'=>'', 'required'=>'true' )) !!}
                        </div>
                        <div class="col-xs-12 col-md-2">

                        </div>
                    </div>
                    <hr>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-4">
                            <button type="submit" name="submit" class="btn green"><i class="fa  fa-save "></i> Save</button>
                            <button type="submit" name="apply" value="apply" class="btn blue"><i class="fa  fa-check-circle"></i> Apply Change(s)</button>
                            <button type="button" onclick="location.href='{{ URL::to('user/groups?return='.$return) }}' " class="btn btn-default "><i class="fa  fa-arrow-circle-left "></i> Cancel </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    	{!! Form::close() !!}
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {

    });
</script>
@stop