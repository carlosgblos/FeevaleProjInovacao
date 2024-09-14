<?php $__env->startSection('title', 'Carteiras'); ?>

<?php $__env->startSection('content_header'); ?>
    <h1 class="text-primary">Carteiras</h1>
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

    <a href="<?php echo e(route('wallet.create')); ?>" class="btn btn-primary mb-3">Adicionar Nova Carteira</a>

    <div class="card card-white">
        <div class="card-header">
            <h3 class="card-title">Lista de Carteiras</h3>
        </div>

        <div class="card-body">
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead class="">
                    <tr>
                        <th>Descrição</th>
                        <th>Moeda</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($wallet->description); ?></td>
                            <td><?php echo e($wallet->currency->description ?? 'N/A'); ?></td>
                            <td>
                                <?php if($wallet->id_owner == auth()->id()): ?>
                                    <a href="<?php echo e(route('wallet.edit', $wallet->id)); ?>" class="btn btn-warning btn-sm">Editar</a>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="<?php echo e($wallet->id); ?>">Excluir</button>
                                    <form id="delete-form-<?php echo e($wallet->id); ?>" action="<?php echo e(route('wallet.destroy', $wallet->id)); ?>" method="POST" style="display:none;">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                    </form>
                                    <?php else: ?>
                                    <span class="text-muted">Sem permissão</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <small class="text-muted">Total Carteiras: <?php echo e($wallets->total()); ?></small>
            <div><?php echo e($wallets->links('vendor.pagination.bootstrap-4')); ?></div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const walletId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Tem certeza?',
                    text: "Essa ação não pode ser revertida!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, excluir!',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(`delete-form-${walletId}`).submit();
                    }
                });
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/wallet/index.blade.php ENDPATH**/ ?>