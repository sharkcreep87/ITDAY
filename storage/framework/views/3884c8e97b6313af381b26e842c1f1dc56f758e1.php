<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>API Toolz | Don't give your time on coding.</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="Don't give your time on coding, API Toolz will code for you." name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/simple-line-icons/simple-line-icons.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-summernote/summernote.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/fancybox/jquery.fancybox.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/icheck/skins/all.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/select2/css/select2.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/select2/css/select2-bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-toastr/toastr.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo e(asset('apitoolz-assets/global/css/components.min.css')); ?>" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/global/css/plugins.min.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <?php echo $__env->yieldContent('style'); ?>
    <!-- BEGIN THEME LAYOUT STYLES -->
    <link href="<?php echo e(asset('apitoolz-assets/layouts/css/layout.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('apitoolz-assets/layouts/css/themes/default.min.css')); ?>" rel="stylesheet" type="text/css" id="style_color" />
    <link href="<?php echo e(asset('apitoolz-assets/css/app.css')); ?>" rel="stylesheet" type="text/css" />
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="<?php echo e(asset('uploads/logo.png')); ?>" /> </head>
<!-- END HEAD -->

<body class="page-container-bg-solid page-header-fixed page-sidebar-fixed page-sidebar-closed-hide-logo">
    <div id="loader" style="display: none;">
        <div class="loader-container">
            <h3 class="loader-back-text">
                <strong id="progress" style="display: none;">0%</strong>
                <img src="<?php echo e(asset('apitoolz-assets/global/img/loader.svg')); ?>" alt="" class="loader">
            </h3>
        </div>
    </div>
    <!-- BEGIN HEADER -->
    <div class="page-header navbar navbar-fixed-top">
        <!-- BEGIN HEADER INNER -->
        <div class="page-header-inner ">
            <!-- BEGIN LOGO -->
            <div class="page-logo">
                <a href="https://developers.apitoolz.com">
                    <h1 class="logo-default bold"><img src="<?php echo e(asset('uploads/logo.svg')); ?>" class="margin-none" /> <span class="font-green">Toolz</span></h1>
                </a>
                <div class="menu-toggler sidebar-toggler">
                </div>
            </div>
            <!-- END LOGO -->
            <!-- BEGIN RESPONSIVE MENU TOGGLER -->
            <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>
            <!-- END RESPONSIVE MENU TOGGLER -->
            <!-- BEGIN PAGE ACTIONS -->
            <div class="page-actions">
                <div class="btn-group">
                    <button type="button" class="btn green btn-sm dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <span class="hidden-sm hidden-xs">Actions&nbsp;</span>
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li>
                            <a href="<?php echo e(url('core/table')); ?>">
                                <i class="icon-drawer"></i> Database Tables </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('core/model')); ?>">
                                <i class="icon-grid"></i> View All Modals </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('core/menu')); ?>">
                                <i class="icon-link"></i> Manage Menus </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a href="<?php echo e(url('core/storage')); ?>">
                                <i class="icon-picture"></i> File Storage
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('core/page')); ?>">
                                <i class="icon-globe"></i> Manage Page
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('core/oauth')); ?>">
                                <i class="icon-screen-tablet"></i> OAuth Clients
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(url('core/settings/general')); ?>">
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
                        <li class="dropdown">
                            <div class="change-mode" id="mode">
                                <input type="checkbox" data-size="mini" data-on-color="success" class="make-switch" data-off-text="Dev" data-on-text="Live" <?php if(env('APP_ENV','local') == 'production'): ?> checked <?php endif; ?>>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="<?php echo e(url('admin')); ?>" target="_blank" class="dropdown-toggle">
                                <i class="icon-screen-desktop"></i>
                            </a>
                        </li>
                        <li class="dropdown dropdown-user dropdown-dark">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                                <span class="username username-hide-on-mobile"> <?php echo e(Auth::user()->first_name); ?> <?php echo e(Auth::user()->last_name); ?> </span>
                                <?php echo SiteHelpers::avatar(40); ?> </a>
                            <ul class="dropdown-menu dropdown-menu-default">
                                <li>
                                    <a href="<?php echo e(url('/')); ?>">
                                        <i class="icon-screen-desktop"></i> Dashboard </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('user/profile')); ?>">
                                        <i class="icon-user"></i> My Profile </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('core/settings/general')); ?>">
                                        <i class="icon-settings"></i> Settings </a>
                                </li>
                                <li class="divider"> </li>
                                <li>
                                    <a href="<?php echo e(url('core/settings/security')); ?>">
                                        <i class="icon-key"></i> Security </a>
                                </li>
                                <li>
                                    <a href="<?php echo e(url('user/logout')); ?>">
                                        <i class="icon-logout"></i> Log Out </a>
                                </li>
                            </ul>
                        </li>
                        <!-- BEGIN USER LOGIN DROPDOWN -->
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
            <div class="page-sidebar navbar-collapse collapse">
                <!-- BEGIN SIDEBAR MENU -->
                <?php if(Request::segment(3) == 'file'): ?>
                <div class="row">
                    <div class="col-md-12 fm-heading"><h3 class="uppercase">File Manager</h3></div>
                    <div class="col-md-12">
                        <div style="display: none;" id="upload-progress">
                            <h4>Uploading...</h4>
                            <div class="progress progress-striped active">
                                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                </div>
                            </div>
                        </div>
                        <div class="page-sidebar-menu" id="divtree"></div>
                    </div>
                </div>
                
                <?php else: ?>
                <ul class="page-sidebar-menu  " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
                    <li class="heading">
                        <h3 class="uppercase">Features</h3>
                    </li>
                    <li class="nav-item  <?php if(Request::segment(2)== 'table'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/table')); ?>" class="nav-link ">
                            <i class="icon-drawer"></i>
                            <span class="title">Database Tables</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'model' && Request::segment(3) != 'create'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/model')); ?>" class="nav-link">
                            <i class="icon-grid"></i>
                            <span class="title">Models</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'menu'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/menu')); ?>" class="nav-link ">
                            <i class="icon-link"></i>
                            <span class="title">Manage Menus</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'api'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/api')); ?>" class="nav-link ">
                            <i class="icon-notebook"></i>
                            <span class="title">API Usage Guide</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'graph'): ?> active <?php endif; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-graph"></i>
                            <span class="title">Graph APIs</span>
                            <span class="arrow <?php if(Request::segment(2)== 'graph'): ?> open <?php endif; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <?php $__currentLoopData = SiteHelpers::models(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item <?php if(Request::segment(2)== 'graph' && Request::segment(3)== $row->module_id): ?> active <?php endif; ?>">
                                    <a href="<?php echo e(url('core/graph/'.$row->module_id.'/index')); ?>" class="nav-link ">
                                        <span class="title"><?php echo e($row->module_title); ?></span>
                                    </a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'storage'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/storage')); ?>" class="nav-link ">
                            <i class="icon-picture"></i>
                            <span class="title">File Storage</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'page'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/page')); ?>" class="nav-link ">
                            <i class="icon-globe"></i>
                            <span class="title">Manage Page</span>
                        </a>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'settings'): ?> active <?php endif; ?>">
                        <a href="javascript:;" class="nav-link nav-toggle">
                            <i class="icon-settings"></i>
                            <span class="title">Settings</span>
                            <span class="arrow <?php if(Request::segment(2)== 'settings'): ?> open <?php endif; ?>"></span>
                        </a>
                        <ul class="sub-menu">
                            <li class="nav-item <?php if(Request::segment(2)== 'settings' && Request::segment(3) == 'general'): ?> active <?php endif; ?>">
                                <a href="<?php echo e(url('core/settings/general')); ?>" class="nav-link ">
                                    <span class="title">General</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if(Request::segment(2)== 'settings' && Request::segment(3) == 'security'): ?> active <?php endif; ?>">
                                <a href="<?php echo e(url('core/settings/security')); ?>" class="nav-link ">
                                    <span class="title">Security</span>
                                </a>
                            </li>
                            <li class="nav-item <?php if(Request::segment(2)== 'settings' && Request::segment(3) == 'connection'): ?> active <?php endif; ?>">
                                <a href="<?php echo e(url('core/settings/connection')); ?>" class="nav-link ">
                                    <span class="title">SSH Connection</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item <?php if(Request::segment(2)== 'oauth'): ?> active <?php endif; ?>">
                        <a href="<?php echo e(url('core/oauth')); ?>" class="nav-link ">
                            <i class="icon-screen-tablet"></i>
                            <span class="title">OAuth2 Clients</span>
                        </a>
                    </li>
                </ul>
                <?php endif; ?>
                <!-- END SIDEBAR MENU -->
            </div>
            <!-- END SIDEBAR -->
        </div>
        <!-- END SIDEBAR -->
        <!-- BEGIN CONTENT -->
        <div class="page-content-wrapper">
            <?php echo $__env->yieldContent('content'); ?>                
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
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript" ></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/js.cookie.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery.blockui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/icheck/icheck.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/select2/js/select2.full.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery.jCombo.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/fancybox/jquery.fancybox.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-summernote/summernote.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-tagsinput/bootstrap-tagsinput.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/simpleclone.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-toastr/toastr.min.js')); ?>" type="text/javascript"></script>

    <!-- END CORE PLUGINS -->
    <?php echo $__env->yieldContent('plugin'); ?>
    <!-- BEGIN THEME GLOBAL SCRIPTS -->
    <script src="<?php echo e(asset('apitoolz-assets/global/scripts/app.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('apitoolz-assets/js/core.js')); ?>" type="text/javascript"></script>
    <!-- END THEME GLOBAL SCRIPTS -->
    <?php echo $__env->yieldContent('script'); ?>
    <?php echo $__env->yieldContent('ext_script'); ?>
    <!-- BEGIN THEME LAYOUT SCRIPTS -->
    <script src="<?php echo e(asset('apitoolz-assets/layouts/scripts/layout.min.js')); ?>" type="text/javascript"></script>
    <!-- END THEME LAYOUT SCRIPTS -->
    <script type="text/javascript">
    $(document).ready(function(){

        $('#mode .make-switch').on('switchChange.bootstrapSwitch', function (e, state) {
            window.location.href = '<?php echo e(url("core/settings/mode")); ?>/'+state;
        }); 
        
    });
    </script>
</body>


</html>