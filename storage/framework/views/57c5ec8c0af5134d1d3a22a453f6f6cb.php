<!-- resources/views/currency/edit.blade.php -->



<?php $__env->startSection('title', 'Edit Currency'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Edit Currency</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('currency.update', $currency->id)); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <?php echo method_field('PUT'); ?>

    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control" value="<?php echo e($currency->description); ?>">
    </div>

    <div class="form-group">
        <label for="abbreviation">Abbreviation</label>
        <input type="text" name="abbreviation" class="form-control" value="<?php echo e($currency->abbreviation); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Currency</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/carlos/LaravelInstall/cgbBudgetAdminLTE/resources/views/currency/edit.blade.php ENDPATH**/ ?>