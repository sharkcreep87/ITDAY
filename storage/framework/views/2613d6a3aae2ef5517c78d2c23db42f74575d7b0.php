<!-- entends your master view: If you have not created master view, first create master view -->
 

<?php $__env->startSection('styles'); ?>
<!-- Add your page style code -->
<!-- If you don't need this section, remove this.. -->
<!-- And if you didn't added this section in your master view, remove this. -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Add your content code -->
<!-- If you didn't added this section in your master view, remove this. -->
<section class="container" ng-controller="RegisterController">
	<div class="content">
		<div class="row">
              <div class="col-md-8 col-md-offset-2">
                  <div class="panel panel-default">
                      <div class="panel-heading">Register</div>
                      <div class="panel-body">
                          <form class="form-horizontal" role="form" method="POST" ng-submit="create()">
                              <div class="form-group">
                                  <label for="first_name" class="col-md-4 control-label">First Name</label>

                                  <div class="col-md-6">
                                      	<input id="first_name" type="text" class="form-control" ng-model="user.first_name" required autofocus>
							<span class="help-block"></span>
                                  </div>
                              </div>
                            
                            	<div class="form-group">
                                  <label for="last_name" class="col-md-4 control-label">Last Name</label>

                                  <div class="col-md-6">
                                      	<input id="last_name" type="text" class="form-control" ng-model="user.last_name" required>
                                  </div>
                              </div>
                            
                            	<div class="form-group">
                                  <label for="username" class="col-md-4 control-label">Username</label>

                                  <div class="col-md-6">
                                      	<input id="username" type="text" class="form-control" ng-model="user.username" required>
                                  </div>
                              </div>

                              <div class="form-group">
                                  <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                  <div class="col-md-6">
                                      	<input id="email" type="email" class="form-control" ng-model="user.email" required>
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
                                  <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                  <div class="col-md-6">
                                      	<input id="password-confirm" type="password" class="form-control" ng-model="user.password_confirmation" required>
                                  </div>
                              </div>
                            
                            	<div class="form-group">
                                  <label for="phone" class="col-md-4 control-label">Phone</label>

                                  <div class="col-md-6">
                                      	<input id="phone" type="phone" class="form-control" ng-model="user.phone">
                                  </div>
                              </div>

                              <div class="form-group">
                                  <div class="col-md-6 col-md-offset-4">
                                      <button type="submit" class="btn btn-primary">
                                          Register
                                      </button>
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
<script src="<?php echo e(asset('js/angular/controllers/RegisterController.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>