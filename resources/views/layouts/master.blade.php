<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>{{env('APP_NAME')}}</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="{{env('APP_DESC')}}" name="description" />
    <meta content="{{env('APP_COMNAME')}}" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-summernote/summernote.css')}}" rel="stylesheet">
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <link href="{{ asset('apitoolz-assets/global/plugins/fancybox/jquery.fancybox.css') }}" rel="stylesheet">
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/icheck/skins/all.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="{{ asset('apitoolz-assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
    <link href="{{ asset('apitoolz-assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    @yield('style')
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="{{ asset('apitoolz-assets/layouts/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/layouts/css/themes/default.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
    <link href="{{ asset('apitoolz-assets/layouts/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('apitoolz-assets/css/app.css') }}" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="{{ asset('uploads/logo.png') }}" /> </head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-fixed page-sidebar-fixed page-sidebar-closed-hide-logo">
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="/">
                    @if(file_exists(public_path().'/uploads/'.env('APP_LOGO')))
                    <span class="logo-default">
                        <img src="{{ asset('uploads/'.env('APP_LOGO')) }}"/> 
                    </span>
                    @else
                    <h1 class="logo-default bold"><img src="{{ asset('uploads/logo.svg') }}" class="margin-none" /> <span class="font-green">Toolz</span></h1>
                    @endif
                </a>
                <div class="menu-toggler sidebar-toggler">
                    <!-- DOC: Remove the above "hide" to enable the sidebar toggler button on header -->
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN PAGE ACTIONS -->
            <!-- DOC: Remove "hide" class to enable the page header actions -->
            <div class="page-actions">
                <div class="btn-group">
                    <button type="button" class="btn green btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="hidden-sm hidden-xs">Actions&nbsp;</span>
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="{{url('core/table')}}">
                                <i class="icon-drawer"></i> Database Tables </a>
                        </li>
                        <li>
                            <a href="{{url('core/model')}}">
                                <i class="icon-grid"></i> View All Models </a>
                        </li>
                        <li>
                            <a href="{{url('core/menu')}}">
                                <i class="icon-link"></i> Manage Menus </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a href="{{url('core/storage')}}">
                                <i class="icon-picture"></i> File Storage
                            </a>
                        </li>
                        <li>
                            <a href="{{url('core/page')}}">
                                <i class="icon-globe"></i> Manage Page
                            </a>
                        </li>
                        <li>
                            <a href="{{url('core/oauth')}}">
                                <i class="icon-screen-tablet"></i> OAuth Clients
                            </a>
                        </li>
                        <li>
                            <a href="{{url('core/settings/general')}}">
                                <i class="icon-settings"></i> Settings </a>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- END PAGE ACTIONS -->
            <!-- BEGIN PAGE TOP -->
            <div class="page-top">
                <!-- BEGIN TOP NAVIGATION MENU -->
                <div class="top-menu">
                    <ul class="nav navbar-nav pull-right">
                        <!-- BEGIN QUICK SIDEBAR TOGGLER -->
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile"> {{Auth::user()->first_name}} {{Auth::user()->last_name}} </span>
                                <!-- DOC: Do not remove below empty space(&nbsp;) as its purposely used -->
                                {!!SiteHelpers::avatar(40)!!} </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="{{url('/')}}">
                                        <i class="icon-screen-desktop"></i> Dashboard </a>
                                </li>
                                <li>
                                    <a href="{{url('user/profile')}}">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li>
                                    <a href="{{url('core/settings/general')}}">
                                        <i class="icon-settings"></i> Settings </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="{{url('core/settings/security')}}">
                                        <i class="icon-key"></i> Security </a>
                                </li>
                                <li>
                                    <a href="{{url('user/logout')}}">
                                        <i class="icon-logout"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- END USER LOGIN DROPDOWN -->
                        <li class="dropdown">
                            <a href="{{url('user/logout')}}" class="dropdown-toggle">
                                <i class="icon-logout"></i>
                            </a>
                        </li>
                        <!-- END QUICK SIDEBAR TOGGLER -->
                    </ul>
                </div>
                <!-- END TOP NAVIGATION MENU -->
            </div>
            <!-- END PAGE TOP -->
        </div>
        <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
        <!-- BEGIN SIDEBAR -->
        <div class="page-sidebar-wrapper">
            <!-- BEGIN SIDEBAR -->
            <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
            <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <ul class="page-sidebar-menu   " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="nav-item start @if(Request::segment(1)== '' || Request::segment(1)== 'dashboard') active @endif">
                        <a href="/" class="nav-link">
                            <i class="icon-home"></i>
                            <span class="title">Dashboard</span>
                        </a>
                    </li>
                    <li class="heading">
                        <h3 class="uppercase">Models</h3>
                    </li>
                    @foreach(SiteHelpers::menus() as $menu)
                    <li class="nav-item @if(SiteHelpers::active(Request::segment(2), $menu['menu_id'])) active @endif}} ">
                      @if($menu['module'] =='separator')
                      <li class="separator"> <span> {{$menu['menu_name']}} </span></li>
                      @else
                      <a @if(count($menu['childs']) == 0 && $menu[ 'menu_type']=='external' ) href="{{ $menu['url'] }}" @elseif(count($menu['childs']) == 0) href="{{url('admin/'.strtolower($menu['module']))}}" @endif class="nav-link ">
                          <i class="{{$menu['menu_icons']}}"></i> 
                          <span class="title">{{$menu['menu_name']}}</span>                  
                          @if(count($menu['childs']) > 0 )
                          <span class="arrow @if(SiteHelpers::active(Request::segment(2), $menu['menu_id'])) open @endif"></span>
                          @endif    
                      </a>
                      @endif 
                      @if(count($menu['childs']) > 0)
                      <ul class="sub-menu">
                          @foreach ($menu['childs'] as $menu2)
                          <li class="nav-item @if(SiteHelpers::active(Request::segment(2), $menu2['menu_id'])) active @endif">
                              <a @if(count($menu2['childs']) == 0 && $menu2[ 'menu_type']=='external' ) href="{{ $menu2['url']}}" @elseif(count($menu2['childs']) == 0) href="{{url('admin/'.strtolower($menu2['module']))}}" @endif>
                                  <i class="{{$menu2['menu_icons']}}"></i> 
                                  <span class="title">{{$menu2['menu_name']}}</span>
                                  @if(count($menu2['childs']) > 0 )
                                  <span class="arrow @if(SiteHelpers::active(Request::segment(2), $menu2['menu_id'])) open @endif"></span>
                                  @endif
                              </a>
                              @if(count($menu2['childs']) > 0)
                              <ul class="sub-menu">
                                  @foreach($menu2['childs'] as $menu3)
                                  <li class="nav-item @if(Request::segment(2)==strtolower($menu3['module'])) active @endif">
                                        <a @if($menu['menu_type']=='external' ) href="{{ $menu3['url'] }}" @else href="{{url('admin/'.strtolower($menu3['module']))}}" @endif>
                                            <i class="{{$menu3['menu_icons']}}"></i> 
                                            <span class="title">{{$menu3['menu_name']}}</span>
                                        </a>
                                  </li>
                                  @endforeach
                              </ul>
                              @endif
                          </li>
                          @endforeach
                      </ul>
                      @endif
                  </li>
                    @endforeach
                    <li class="nav-item @if(Request::segment(1)== 'user') active @endif">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-users"></i>
                            <span class="title">User</span>
                            <span class="arrow @if(Request::segment(1)== 'user') open @endif"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item @if(Request::segment(1)== 'user' && Request::segment(2) == '') active @endif">
                                <a href="{{url('user')}}" class="nav-link ">
                                    <span class="title">Users</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Request::segment(1)== 'user' && Request::segment(2) == 'groups') active @endif">
                                <a href="{{url('user/groups')}}" class="nav-link ">
                                    <span class="title">Groups</span>
                                </a>
                            </li>
                            <li class="nav-item @if(Request::segment(1)== 'user' && Request::segment(2) == 'logs') active @endif">
                                <a href="{{url('user/logs')}}" class="nav-link ">
                                    <span class="title">Logs</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item  ">
                        <a href="{{url('user/logout')}}" class="nav-link ">
                            <i class="icon-logout"></i>
                            <span class="title">Exit</span>
                        </a>
                    </li>
                </ul>
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            @yield('content')                
        </div>
        <!-- END CONTENT -->
        
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="page-footer">
        <div class="page-footer-inner"> 2017 &copy; API Toolz by
            <a target="_blank" href="http://msdt.com.mm">M S D T Co., Ltd.</a>
        </div>
        <div class="scroll-to-top">
            <i class="icon-arrow-up"></i>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- POPUP MODAL FADE -->
    <div class="modal fade" id="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header bg-red font-white">
                <button type="button " class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="modal-title">Modal title</h4>
            </div>
            <div class="modal-body" id="modal-content">

            </div>

          </div>
        </div>
    </div>
    <!-- END POPUP MODAL FADE -->

    <!-- BEGIN CORE PLUGINS -->
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery-ui/jquery-ui.min.js') }}" type="text/javascript" ></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/js.cookie.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery.blockui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/icheck/icheck.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery.jCombo.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/fancybox/jquery.fancybox.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-summernote/summernote.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/simpleclone.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/global/plugins/jquery.hotkeys.js') }}" type="text/javascript"></script>
    <!-- END CORE PLUGINS -->
    @yield('plugin')
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="{{ asset('apitoolz-assets/global/scripts/app.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('apitoolz-assets/js/core.js') }}" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    @yield('script')
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="{{ asset('apitoolz-assets/layouts/scripts/layout.min.js') }}" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
</body>


</html>