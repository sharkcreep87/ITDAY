<?php $__env->startComponent('mail::message'); ?>
# Hello <?php echo e($firstname.' '.$lastname); ?>,

Thank you for joining with us.<br>
Your account Info...<br>
Email : <?php echo e($email); ?><br>
Password : <?php echo e($password); ?><br>

Please follow link for activation<br>
<?php $__env->startComponent('mail::button', ['url' => url('activation?code='.$code.'&redirectUri='.$redirect), 'color'=>'green']); ?>
Active Account
<?php echo $__env->renderComponent(); ?>

If the link have not working , copy and paste bellow link
<?php echo e(url('activation?code='.$code.'&redirectUri='.$redirect)); ?>


Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
