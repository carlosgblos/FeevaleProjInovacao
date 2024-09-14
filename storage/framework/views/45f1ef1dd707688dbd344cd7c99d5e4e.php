<?php $__env->startSection('title', 'Adicionar Novo Movimento'); ?>

<?php $__env->startSection('content_header'); ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <h1 class="text-primary">Adicionar Novo Movimento</h1>
<?php $__env->stopSection(); ?>

<?php if($errors->any()): ?>
<div class="alert alert-danger">
    <ul>
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
</div>
<?php endif; ?>

<?php $__env->startSection('content'); ?>
    <form action="<?php echo e(route('movement.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="id_wallet">Carteira</label>
                    <select name="id_wallet" id="wallet_id" class="form-control" onchange="loadMovementTypes()">
                        <option value="">Selectione</option>
                        <?php $__currentLoopData = $wallets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wallet): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($wallet->id); ?>"><?php echo e($wallet->description); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_movement_type">Tipo de Movimento</label>
                    <select name="id_movement_type" id="movement_type_id" class="form-control">
                        <!-- Movement types will be loaded dynamically based on the selected wallet -->
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" placeholder="Descrição do Movimento">
                </div>

                <div class="form-group">
                    <label for="transaction_type">Tipo de Transação</label>
                    <select name="transaction_type" class="form-control">
                        <option value="C">Crédito</option>
                        <option value="D">Débito</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vlr">Valor</label>
                    <input type="text" name="vlr" id="vlr" class="form-control" placeholder="Valor">
                </div>

                <div class="form-group">
                    <label for="transaction_at">Data da Transação</label>
                    <input type="text" name="transaction_at" id="transaction_at" class="form-control" placeholder="Data da Transação">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
    </form>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <!-- Load JS plugins for currency formatting and date -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        // Load movement types based on the selected wallet
        function loadMovementTypes() {
            var walletId = document.getElementById('wallet_id').value;
            var movementTypeSelect = document.getElementById('movement_type_id');

            if (walletId) {
                fetch(`/movement_types/${walletId}`)
                    .then(response => response.json())
                    .then(data => {
                        movementTypeSelect.innerHTML = '';
                        data.forEach(function(type) {
                            var option = document.createElement('option');
                            option.value = type.id;
                            option.text = type.description;
                            movementTypeSelect.appendChild(option);
                        });
                    });
            }
        }

        // Format value as currency
        $('#vlr').mask('#.##0,00', {reverse: true});

        // Date picker for transaction date
        flatpickr('#transaction_at', {
            altInput: true,
            altFormat: "d/m/Y",
            dateFormat: "Y-m-d",
            allowInput: true, // This ensures you can also type in the date manually
            enableTime: false,
            defaultDate: "today"   // Set the default date to today's date
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /media/psf/General/FeevaleProject/cgbBudgetAdminLTE/resources/views/movement/create.blade.php ENDPATH**/ ?>