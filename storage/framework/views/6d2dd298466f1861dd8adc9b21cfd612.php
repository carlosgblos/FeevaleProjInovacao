<!-- resources/views/currency/create.blade.php -->



<?php $__env->startSection('title', 'Add Currency'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Add New Currency</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('currency.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="form-group">
        <label for="description">Description</label>
        <input type="text" name="description" class="form-control" placeholder="Enter description">
    </div>

    <div class="form-group">
        <label for="abbreviation">Abbreviation</label>
        <input type="text" name="abbreviation" class="form-control" placeholder="Enter abbreviation" required>
    </div>

    <button type="submit" class="btn btn-primary">Add Currency</button>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/carlos/LaravelInstall/cgbBudgetAdminLTE/resources/views/currency/create.blade.php ENDPATH**/ ?>