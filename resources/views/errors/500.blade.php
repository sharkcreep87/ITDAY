<!DOCTYPE html>
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
<head>
        <meta charset="utf-8" />
        <title>API Toolz | DON'T GIVE YOUR TIME ON CODING!</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Don't give your time on coding. API Toolz will code for you. Get RESTfull API without any coding in a minute." name="description" />
        <meta content="API Toolz" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ asset('apitoolz-assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('apitoolz-assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ asset('apitoolz-assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ asset('apitoolz-assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ asset('apitoolz-assets/css/error.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <body class=" page-500-full-page">
        <div class="row">
            <div class="col-md-12 page-500">
                <div class=" number font-red"> 500 </div>
                <div class=" details">
                    <h3>Oops! Something went wrong.</h3>
                    <p> We are fixing it! Please come back in a while.
                        <br/> </p>
                    <p>
                        <form action="{{url('error')}}" method="POST">
                            {{csrf_field()}}
                            <input type="hidden" name="message" value="{{$message}}">
                            <input type="hidden" name="code" value="{{$code}}">
                            <input type="hidden" name="file" value="{{$file}}">
                            <input type="hidden" name="line" value="{{$line}}">
                            <a href="/" class="btn red btn-outline"> Return home </a>
                            <button type="submit" class="btn red"> Report Error </button>
                        </form>
                        <br> 
                    </p>
                    <p class="error-msg" style="display: none;">
                        <strong>Exception:</strong> {{$message}}<br>
                        {{$file}} {{$line}}
                    </p>
                </div>

            </div>
        </div>
        <!--[if lt IE 9]>
<script src="{{ asset('apitoolz-assets/global/plugins/respond.min.js') }}"></script>
<script src="{{ asset('apitoolz-assets/global/plugins/excanvas.min.js') }}"></script> 
<script src="{{ asset('apitoolz-assets/global/plugins/ie8.fix.min.js') }}"></script> 
<![endif]-->
        <!-- BEGIN CORE PLUGINS -->
        <script src="{{ asset('apitoolz-assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('apitoolz-assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('apitoolz-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('apitoolz-assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ asset('apitoolz-assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script type="text/javascript">
            $(document).ready(function () {
                $("p").dblclick(function(){
                    $('.error-msg').show();
                });
            })
        </script>
</html>