<?php $__env->startComponent('mail::message'); ?>
# Hello Admin

Please check following error:

Exception: <?php echo e($message); ?> #<?php echo e($code); ?>


<?php echo e($file); ?>: <?php echo e($line); ?>


Thanks,<br>
<?php echo e(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>