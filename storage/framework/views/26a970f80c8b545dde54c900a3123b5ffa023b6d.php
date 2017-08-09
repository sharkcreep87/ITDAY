
<?php $__env->startSection('content'); ?>
<!-- BEGIN REGISTRATION FORM -->
<form class="" action="<?php echo e('register'); ?>" method="post" data-parsley-validate>
    <?php echo e(csrf_field()); ?>

    <h3 class="font-green">Sign Up</h3>
    <p class="hint"> Enter your personal details below: </p>
    <?php if(session('message')): ?>
        <div class="alert <?php if(session('status') == 'success'): ?> alert-success <?php else: ?> alert-danger <?php endif; ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?>
    <div class="form-group <?php echo e($errors->has('first_name') ? 'has-error' : ''); ?>">
        <label class="control-label visible-ie8 visible-ie9">First Name</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="First Name" name="first_name" value="<?php echo e(old('first_name')); ?>" required />
        <?php if($errors->has("first_name")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("first_name")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <div class="form-group <?php echo e($errors->has('last_name') ? 'has-error' : ''); ?>">
        <label class="control-label visible-ie8 visible-ie9">Last Name</label>
        <input class="form-control placeholder-no-fix" type="text" placeholder="Last Name" name="last_name" value="<?php echo e(old('last_name')); ?>" required />
        <?php if($errors->has("last_name")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("last_name")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <div class="form-group <?php echo e($errors->has('email') ? 'has-error' : ''); ?>">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Email</label>
        <input class="form-control placeholder-no-fix" type="email" placeholder="Email" name="email" value="<?php echo e(old('email')); ?>" required />
        <?php if($errors->has("email")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("email")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <p class="hint"> Enter your account details below: </p>
    <div class="form-group <?php echo e($errors->has('username') ? 'has-error' : ''); ?>">
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Username" name="username" value="<?php echo e(old('username')); ?>" required />
        <?php if($errors->has("username")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("username")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <div class="form-group <?php echo e($errors->has('password') ? 'has-error' : ''); ?>">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" id="register_password" placeholder="Password" name="password" value="<?php echo e(old('password')); ?>" required/>
        <?php if($errors->has("password")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("password")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <div class="form-group <?php echo e($errors->has('password_confirmation') ? 'has-error' : ''); ?>">
        <label class="control-label visible-ie8 visible-ie9">Re-type Your Password</label>
        <input class="form-control placeholder-no-fix" type="password" autocomplete="off" placeholder="Re-type Your Password" name="password_confirmation" required/>
        <?php if($errors->has("password_confirmation")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("password_confirmation")); ?></strong>
        </span>
        <?php endif; ?>
    </div>
    <div class="form-group <?php echo e($errors->has('tnc') ? 'has-error' : ''); ?> margin-top-20 margin-bottom-20">
        <label class="mt-checkbox mt-checkbox-outline icheck">
            <input type="checkbox" name="tnc" required/> I agree to the
            <a href="javascript:;">Terms of Service </a> &
            <a href="javascript:;">Privacy Policy </a>
            <span></span>
        </label>
        <?php if($errors->has("tnc")): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first("tnc")); ?></strong>
        </span>
        <?php endif; ?>
        <div id="register_tnc_error"> </div>
    </div>
    <div class="form-actions">
        <a href="<?php echo e(url('login')); ?>" id="register-back-btn" class="btn green btn-outline">Back</a>
        <button type="submit" id="register-submit-btn" class="btn btn-success uppercase pull-right">Submit</button>
    </div>
</form>
<!-- END REGISTRATION FORM -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('user.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>