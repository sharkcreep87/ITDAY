<!-- entends your master view: If you have not created master view, first create master view -->
 

<?php $__env->startSection('styles'); ?>
<!-- Add your page style code -->
<!-- If you don't need this section, remove this.. -->
<!-- And if you didn't added this section in your master view, remove this. -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Add your content code -->
<!-- If you didn't added this section in your master view, remove this. -->
<section class="container">
	<div class="content">
		<div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                      <div class="panel-heading">Login</div>
                      <div class="panel-body" ng-controller="LoginController">
                          <?php if(Request::input('message')): ?>
                          <div class="alert alert-<?php echo e(Request::input('status')); ?> alert-dismissible fade in" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button> 
                              <strong>Message!</strong> <?php echo e(Request::input('message')); ?>

                          </div>
                          <?php endif; ?>
                      	  <p class="alert alert-danger" style="display: none;"></p>
                          <form class="form-horizontal" role="form" method="POST" ng-submit="signin()">
			
                            <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                                  <div class="col-md-6">
                                      	<input id="email" type="email" class="form-control" ng-model="user.email" required autofocus>
                                    	<span class="help-block"></span>
                                  </div>
                              </div>
                            
                              <div class="form-group">
                                  <label for="password" class="col-md-4 control-label">Password</label>
                                  <div class="col-md-6">
                                      <input id="password" type="password" class="form-control" ng-model="user.password" required>
							<span class="help-block"></span>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <div class="checkbox">
                                          <label>
                                              <input type="checkbox" ng-model="user.remember"> Remember Me
                                          </label>
                                      </div>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-8 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Login
                                      </button>
                                      <a class="btn btn-link" href="#">
                                          Forgot Your Password?
                                      </a>
                                  </div>
                              </div>
                          </form>
                      </div>
                  </div>
              </div>
           </div>
	</div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="<?php echo e(asset('js/angular/controllers/LoginController.js')); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>