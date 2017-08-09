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
    <div class="row">
        <div class="col-md-12">
            <div class="page-header">
                <h1>
                About Us 
                <small>How it all began</small>
              </h1>
            </div>
            <div class="block block-border-bottom-grey block-pd-sm">
                <h3 class="block-title">
                What Makes Us Tick!
              </h3>
                <img src="<?php echo e(asset('img/about-us.png')); ?>" alt="About us" class="img-responsive img-thumbnail pull-right m-l m-b">
                <p>Elit pellentesque dolor facilisis aenean eu tempor, phasellus lundium risus dolor, augue, ridiculus nascetur odio ridiculus? Hac ac, adipiscing ut dapibus. Adipiscing cras in? Magna nisi augue odio! Pellentesque magnis? Lacus integer magnis purus sed mus lorem aliquam lectus, placerat pellentesque quis, nunc urna turpis lorem. Etiam velit, augue sed magnis placerat! In cras, dignissim lorem, porttitor in velit in, nisi vut a cursus cum, odio sagittis nisi turpis? Mus penatibus non, pulvinar porttitor arcu hac ut et ac integer? Ultricies est etiam sit. Urna ridiculus facilisis pulvinar, ultrices augue? Parturient velit non tincidunt sit sagittis pulvinar phasellus rhoncus hac! Sit porta. Tristique, hac. Porttitor adipiscing ac. Ac tincidunt a porttitor natoque auctor ultricies! Proin nunc scelerisque? Habitasse adipiscing? Cursus.</p>
                <p>Elit pellentesque dolor facilisis aenean eu tempor, phasellus lundium risus dolor, augue, ridiculus nascetur odio ridiculus? Hac ac, adipiscing ut dapibus. Adipiscing cras in? Magna nisi augue odio! Pellentesque magnis? Lacus integer magnis purus sed mus lorem aliquam lectus, placerat pellentesque quis, nunc urna turpis lorem. Etiam velit, augue sed magnis placerat! In cras, dignissim lorem, porttitor in velit in, nisi vut a cursus cum, odio sagittis nisi turpis? Mus penatibus non, pulvinar porttitor arcu hac ut et ac integer? Ultricies est etiam sit. Urna ridiculus facilisis pulvinar, ultrices augue? Parturient velit non tincidunt sit sagittis pulvinar phasellus rhoncus hac! Sit porta. Tristique, hac. Porttitor adipiscing ac. Ac tincidunt a porttitor natoque auctor ultricies! Proin nunc scelerisque? Habitasse adipiscing? Cursus.</p>
            </div>
            <div class="block-highlight block-pd-h block-pd-sm">
                <h3 class="block-title">
                Our Mission
              </h3>
                <p class="text-fancy">Vel in amet mauris? Turpis pulvinar a proin tincidunt pid, vel odio lundium sit, cras. Duis mattis porttitor nunc elementum eros, in turpis nec. Lectus dictumst risus ut ac porta, urna ac vel, a ut dis!</p>
            </div>
            <div class="block">
                <h3 class="block-title">
                Vital Stats
              </h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="stat">
                            <span data-counter-up="">1000</span>s
                            <small>Happpy Customers</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <span data-counter-up="">163</span>+
                            <small>GB Transfered</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="stat">
                            <span data-counter-up="">214</span>
                            <small>Bugs Fixed</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<!-- Add your page script code-->
<!-- If you don't need this section, remove this. -->
<!-- And if you didn't added this section in your master view, remove this. -->
<?php $__env->stopSection(); ?>
<?php echo $__env->make('pages.master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>