<?php $__env->startSection('title', 'Movimentos'); ?>

<?php $__env->startSection('content_header'); ?>
<h1 class="text-primary">Movimentos</h1>
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
<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<a href="<?php echo e(route('movement.create')); ?>" class="btn btn-primary mb-3">Adicionar Novo Movimento</a>

<!-- Filter Form -->
<form action="<?php echo e(route('movement.index')); ?>" method="GET" class="form-inline mb-4">
    <div class="form-group mr-3">
        <label for="description" class="mr-2">Descrição do Movimento</label>
        <input type="text" name="description" id="description" class="form-control" placeholder="Descrição do Movimento" value="<?php echo e(request()->get('description')); ?>">
    </div>

    <div class="form-group mr-3">
        <label for="id_movement_type" class="mr-2">Tipo de Movimento</label>
        <select name="id_movement_type" id="id_movement_type" class="form-control">
            <option value="">Todos</option>
            <?php $__currentLoopData = $movementTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($type->id); ?>" <?php echo e(request()->get('id_movement_type') == $type->id ? 'selected' : ''); ?>>
                <?php echo e($type->description); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="transaction_at_start" class="mr-2">Data Início</label>
        <input type="text" name="transaction_at_start" id="transaction_at_start" class="form-control" placeholder="Data Início" value="<?php echo e(request()->get('transaction_at_start')); ?>">
    </div>

    <div class="form-group mr-3">
        <label for="transaction_at_end" class="mr-2">Data Fim</label>
        <input type="text" name="transaction_at_end" id="transaction_at_end" class="form-control" placeholder="Data Fim" value="<?php echo e(request()->get('transaction_at_end')); ?>">
    </div>

    <div class="form-group mr-3">
        <label for="wallet" class="mr-2">Carteira</label>
        <select name="wallet_id" id="wallet" class="form-control">
            <option value="">Todas</option>
            <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($wallet->id); ?>" <?php echo e(request()->get('wallet_id') == $wallet->id ? 'selected' : ''); ?>>
                <?php echo e($wallet->description); ?>

            </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="transaction_type" class="mr-2">Tipo de Transação</label>
        <select name="transaction_type" id="transaction_type" class="form-control">
            <option value="">Todos</option>
            <option value="C" <?php echo e(request()->get('transaction_type') == 'C' ? 'selected' : ''); ?>>Crédito</option>
            <option value="D" <?php echo e(request()->get('transaction_type') == 'D' ? 'selected' : ''); ?>>Débito</option>
        </select>
    </div>

    <button type="submit" class="btn btn-primary">Filtrar</button>
</form>


<div class="card">
    <div class="card-header"> <!-- No additional class -->
        <h3 class="card-title">Lista de Movimentos</h3>
    </div>

    <div class="card-body">
        <table class="table table-sm table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Data</th>
                <th>Tipo</th>
                <th>Carteira</th>
                <th style="width: 150px;">Ações</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($movement->description); ?></td>
                <td><?php echo e(number_format($movement->vlr, 2, ',', '.')); ?></td>
                <td><?php echo e($movement->transaction_at->format('d/m/Y')); ?></td>
                <td><?php echo e($movement->transaction_type == 'C' ? 'Crédito' : 'Débito'); ?></td>
                <td><?php echo e($movement->wallet->description); ?></td>
                <td>
                    <a href="<?php echo e(route('movement.edit', $movement->id)); ?>" class="btn btn-warning btn-sm">Editar</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="<?php echo e($movement->id); ?>">Excluir</button>
                    <form id="delete-form-<?php echo e($movement->id); ?>" action="<?php echo e(route('movement.destroy', $movement->id)); ?>" method="POST" style="display:none;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <small class="text-muted">Total Movimentos: <?php echo e($movements->total()); ?></small>
        <div><?php echo e($movements->links('vendor.pagination.bootstrap-4')); ?></div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const movementId = this.getAttribute('data-id');

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
                    document.getElementById(`delete-form-${movementId}`).submit();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/movement/index.blade.php ENDPATH**/ ?>