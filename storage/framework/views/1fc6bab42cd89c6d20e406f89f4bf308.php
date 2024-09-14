<?php $__env->startSection('title', 'Adicionar Novo Compartilhamento'); ?>

<?php $__env->startSection('content_header'); ?>
<h1 class="text-primary">Adicionar Novo Compartilhamento de Carteira</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<form action="<?php echo e(route('walletshared.store')); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="wallet_id">Carteira</label>
                <select name="wallet_id" class="form-control">
                    <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($wallet->id); ?>"><?php echo e($wallet->description); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email para Compartilhamento">
            </div>

            <div class="form-group">
                <label for="reason">Razão</label>
                <textarea name="reason" class="form-control" placeholder="Razão para o Compartilhamento"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
    </div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/walletshared/create.blade.php ENDPATH**/ ?>