@extends('layouts.master') @section('content')
<div class="page-content row">
    <!-- Page header -->
    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered animated fadeInUp ">
        	<div class="portlet-title hidden-xs">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption">
                    {icon}<span class="caption-subject font-red bold">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions ">
            		<a href="{{ url('admin/{class}?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back to Listing"><i class="fa  fa-arrow-left"></i></a> @if($access['is_add'] ==1)
                    <a href="{{ url('admin/{class}/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="Edit {{ $pageTitle }}"><i class="fa  fa-pencil"></i></a> @endif
                    <a href="{{ ($prevnext['prev'] != '' ? url('admin/{class}/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>
                    <a href="{{ ($prevnext['next'] != '' ? url('admin/{class}/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
            <div class="portlet-body">

                <table class="table table-striped table-bordered">
                    <tbody>
                        {form_view}
                    </tbody>
                </table>

                {masterdetailview}

            </div>
        </div>

    </div>
</div>

@stop