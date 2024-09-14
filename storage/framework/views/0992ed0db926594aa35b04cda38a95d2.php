<?php $__env->startSection('title', 'Editar Carteira'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="text-primary">Editar Carteira</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    <?php endif; ?>

    <div class="card card-white">
        <div class="card-body">
            <form action="<?php echo e(route('wallet.update', $wallet->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" value="<?php echo e($wallet->description); ?>" placeholder="Descrição da Carteira">
                </div>

                <div class="form-group">
                    <label for="id_currency">Moeda</label>
                    <select name="id_currency" class="form-control">
                        <option value="">Selecione uma moeda</option>
                        <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($currency->id); ?>" <?php echo e($wallet->id_currency == $currency->id ? 'selected' : ''); ?>>
                                <?php echo e($currency->description); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/wallet/edit.blade.php ENDPATH**/ ?>