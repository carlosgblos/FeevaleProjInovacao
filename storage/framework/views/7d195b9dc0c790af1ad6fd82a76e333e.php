<?php $__env->startSection('title', 'Adicionar Novo Tipo de Movimento'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="text-primary">Adicionar Novo Tipo de Movimento</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('movement_type.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" placeholder="Descrição do Tipo de Movimento">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/movement_type/create.blade.php ENDPATH**/ ?>