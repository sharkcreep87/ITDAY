@extends('layouts.master') @section('content')
<div class="page-content row">
    <div class="page-content-wrapper m-t">

        <div class="portlet light bordered animated fadeInUp">
            <div class="portlet-title">
                @if(isset($pageTitle) && isset($pageAction))
                <div class="caption hidden-xs">
                    {icon}<span class="caption-subject font-blue-sharp bold uppercase">{{ $pageTitle }} : <small> {{ $pageAction }}</small></span>
                </div>
                @endif
                <div class="actions">
                    <a href="{{ url('admin/{class}?return='.$return) }}" class="tips btn btn-xs btn-default" title="Back"><i class="fa  fa-arrow-left"></i></a> @if($access['is_add'] ==1)
                    <a href="{{ url('admin/{class}/update/'.$id.'?return='.$return) }}" class="tips btn btn-xs btn-default" title="Edit"><i class="fa  fa-pencil"></i></a> @endif
                    <a href="{{ ($prevnext['prev'] != '' ? url('admin/{class}/show/'.$prevnext['prev'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"><i class="fa fa-arrow-left"></i>  </a>
                    <a href="{{ ($prevnext['next'] != '' ? url('admin/{class}/show/'.$prevnext['next'].'?return='.$return ) : '#') }}" class="tips btn btn-xs btn-default"> <i class="fa fa-arrow-right"></i> </a>
                </div>
            </div>
            <div class="portlet-body">

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab"><b>{{ $pageTitle }} : </b>  View Detail </a></li>
                    @foreach($subgrid as $sub)
                    <li role="presentation"><a href="#{{ str_replace(" ","_",$sub['title']) }}" aria-controls="profile" role="tab" data-toggle="tab"><b>{{ $pageTitle }}</b>  : {{ $sub['title'] }}</a></li>
                    @endforeach
                </ul>

                <!-- Tab panes -->
                <div class="tab-content m-t">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <table class="table table-striped table-bordered">
                            <tbody>
                                {form_view}
                            </tbody>
                        </table>
                    </div>
                    @foreach($subgrid as $sub)
                    <div role="tabpanel" class="tab-pane" id="{{ str_replace(" ","_",$sub['title']) }}"></div>
                    @endforeach
                </div>

            </div>
        </div>

    </div>
</div>
@stop
@section('script')
<script type="text/javascript">
$(function() {
{master_detail}
})
</script>
@endsection