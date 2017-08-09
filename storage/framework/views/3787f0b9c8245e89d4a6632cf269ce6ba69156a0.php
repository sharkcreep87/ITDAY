<!DOCTYPE html>
<html lang="en" ng-app="DefaultTemplate">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <!-- Don't forget to add like this if you are changed with your template! -->
    <title><?php echo e(@$meta_title); ?></title>
    <meta name="keywords" content="<?php echo e(@$meta_keywords); ?>">
    <meta name="description" content="<?php echo e(@$meta_description); ?>">

    <!-- Styles -->
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/custom.css')); ?>" rel="stylesheet">

    <!-- Page Level Styles -->
    <?php echo $__env->yieldContent('styles'); ?>

</head>
<body ng-controller="ApplicationController">
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                        <?php echo e(config('app.name', 'Laravel')); ?>

                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                         
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                      	<li <?php if(Request::segment(1) == ""): ?> class="active" <?php endif; ?>><a href="/">Home</a></li>
                        <li <?php if(Request::segment(1) == "aboutus"): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('aboutus')); ?>">Aboutus</a></li>
                      	<li <?php if(Request::segment(1) == "contactus"): ?> class="active" <?php endif; ?>><a href="<?php echo e(url('contactus')); ?>">Contatus</a></li>
                        <!-- Authentication Links -->

                        <li <?php if(Request::segment(2) == "login"): ?> class="active" <?php endif; ?> ng-if="!AuthService.authenticated()"><a href="<?php echo e(url('user/login')); ?>">Login</a></li>
                        <li <?php if(Request::segment(2) == "register"): ?> class="active" <?php endif; ?> ng-if="!AuthService.authenticated()"><a href="<?php echo e(url('user/register')); ?>">Register</a></li>

                        <li class="dropdown" ng-if="AuthService.authenticated()">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{AuthService.getUser().email}} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="javascript:;" ng-click="AuthService.logout()">
                                        Logout
                                    </a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </div>
            </div>
        </nav>
      
        <?php echo $__env->yieldContent('content'); ?>
      
    </div>

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angular/angular.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angular/angular-local-storage.min.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angular/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/angular/controllers/ApplicationController.js')); ?>"></script>
    <!-- Page Level Scripts -->
    <?php echo $__env->yieldContent('scripts'); ?>

</body>
</html>