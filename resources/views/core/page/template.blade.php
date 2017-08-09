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
            <div class="portlet light portlet-form bordered" ng-controller="TemplateController">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-red"></i>
                        <span class="caption-subject font-red bold">Choose Template</span>
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
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <h1>Choose Template</h1>
                            <div class="c-line-center bg-dark"></div>
                            <h2>If you don't want our template. Click on <span class="font-yellow-gold">No, Thanks.</span></h2>
                            <h2>
                                <a href="{{url('core/page/create')}}" class="btn btn-lg btn-outline green">No, Thanks <i class="fa fa-angle-right"></i></a>
                            </h2>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="row wow">
                        <!-- SINGLE PRODUCT -->
                        @if(is_array($templates))
                            @foreach($templates as $row)
                            <div class="col-md-3">
                                <div class="item" style="background-image: url(https://developers-162.apitoolz.com/img/.template/image/{{$row->image}});">
                                    <div class="item-overlay">
                                    </div>
                                    <div class="item-content">
                                        <div class="item-top-content">
                                            <div class="item-top-content-inner">
                                                <div class="item-product">
                                                    <div class="item-top-title">
                                                        <h5>{{$row->name}}</h5>
                                                        <!-- PRODUCT TITLE-->
                                                        <p class="subdescription limit-line-2">
                                                            {{$row->description}}
                                                        </p>
                                                        <!-- PRODUCT DESCRIPTION-->
                                                    </div>
                                                </div>
                                                <div class="item-product-price">
                                                    <!-- PRICE -->
                                                    <span class="price-num green-text">@if($row->price == 0) Free @else ${{$row->price}} @endif</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- ITEM HOVER CONTENT-->
                                        <div class="item-add-content">
                                            <div class="item-add-content-inner text-center">
                                                <div class="section">
                                                    <a href="{{$row->demo_url}}" target="_blank" class="btn red custom-button">View <i class="fa fa-angle-right"></i></a>
                                                    <a href="{{url('core/page/import-url?_url=https://developers-162.apitoolz.com/.template/'.$row->download_file)}}" class="btn yellow-gold custom-button green-btn">Use <i class="fa fa-angle-right"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                        <!-- / END FIRST ITEM -->
                </div>
            </div>
            <!-- END VALIDATION STATES-->
        </div>
    </div>
</div>
<!-- END CONTENT BODY -->
@endsection
@section('plugin')

@endsection
@section('script')

@endsection