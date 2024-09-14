<?php $__env->startSection('title', 'CGBBudget'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>CGBBudget</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<p>Welcome to this beautiful admin panel.</p>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
<script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/carlos/LaravelInstall/cgbBudgetAdminLTE/resources/views/welcome.blade.php ENDPATH**/ ?>