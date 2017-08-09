<!DOCTYPE html>
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->
<head>
        <meta charset="utf-8" />
        <title>API Toolz | Don't give your time on coding.</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="Don't give your time on coding. API Toolz will code for you." name="description" />
        <meta content="API Toolz" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&amp;subset=all" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/global/plugins/font-awesome/css/font-awesome.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/global/plugins/simple-line-icons/simple-line-icons.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap/css/bootstrap.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="<?php echo e(asset('apitoolz-assets/global/css/components.min.css')); ?>" rel="stylesheet" id="style_components" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/global/css/plugins.min.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="<?php echo e(asset('apitoolz-assets/css/login.min.css')); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo e(asset('apitoolz-assets/css/app.css')); ?>" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="<?php echo e(asset('uploads/logo.png')); ?>" />
    </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <h1 class="bold font-white"><img src="<?php echo e(asset('uploads/logo.svg')); ?>"> API <span class="font-green">Toolz</span></h1>
        </div>
        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <div class="copyright"> 2017 © API Toolz by <a href="http://msdt.com.mm">M S D T Co.,Ltd.</a></div>
        <!-- BEGIN CORE PLUGINS -->
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/js.cookie.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/jquery.blockui.min.js')); ?>" type="text/javascript"></script>
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js')); ?>" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <script src="<?php echo e(asset('apitoolz-assets/global/plugins/parsleyjs/parsley.min.js')); ?>" type="text/javascript"></script>
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="<?php echo e(asset('apitoolz-assets/global/scripts/app.min.js')); ?>" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <?php echo $__env->yieldContent('script'); ?>
        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
</body>
</html>