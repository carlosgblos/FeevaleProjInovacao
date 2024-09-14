<!-- resources/views/currency/edit.blade.php -->



<?php $__env->startSection('title', 'Editar Moeda'); ?>

<?php $__env->startSection('content_header'); ?>
<h1>Editar Moeda</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Atualizar</h3>
    </div>

    <div class="card-body">
        <form action="<?php echo e(route('currency.update', $currency->id)); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <?php echo method_field('PUT'); ?>

            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" name="description" class="form-control" value="<?php echo e($currency->description); ?>">
            </div>

            <div class="form-group">
                <label for="abbreviation">Símbolo</label>
                <input type="text" name="abbreviation" class="form-control" value="<?php echo e($currency->abbreviation); ?>" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/currency/edit.blade.php ENDPATH**/ ?>