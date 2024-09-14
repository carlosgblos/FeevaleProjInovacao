<?php $__env->startSection('title', 'Adicionar Nova Carteira'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="text-primary">Adicionar Nova Carteira</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('wallet.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="form-group">
            <label for="description">Descrição</label>
            <input type="text" name="description" class="form-control" placeholder="Descrição da Carteira">
        </div>

        <div class="form-group">
            <label for="id_currency">Moeda</label>
            <select name="id_currency" class="form-control">
                <option value="">Selecione uma moeda</option>
                <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($currency->id); ?>"><?php echo e($currency->description); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Adicionar</button>
    </form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/wallet/create.blade.php ENDPATH**/ ?>