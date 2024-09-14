<!-- resources/views/currency/index.blade.php -->



<?php $__env->startSection('title', 'Currencies'); ?>

<?php $__env->startSection('content_header'); ?>
<h1 class="text-primary">Currencies</h1>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php if(session('success')): ?>
<div class="alert alert-success">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<a href="<?php echo e(route('currency.create')); ?>" class="btn btn-primary mb-3">Add New Currency</a>

<div class="card">
    <div class="card-header bg-info">
        <h3 class="card-title text-white">Currency List</h3>
    </div>

    <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
            <thead class="bg-primary text-white">
            <tr>
                <th>ID</th>
                <th>Description</th>
                <th>Abbreviation</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($currency->id); ?></td>
                <td><?php echo e($currency->description); ?></td>
                <td><?php echo e($currency->abbreviation); ?></td>
                <td>
                    <a href="<?php echo e(route('currency.edit', $currency->id)); ?>" class="btn btn-warning btn-sm">Edit</a>

                    <!-- Delete button with SweetAlert confirmation -->
                    <button class="btn btn-danger btn-sm btn-delete" data-id="<?php echo e($currency->id); ?>">Delete</button>

                    <!-- Hidden form for delete request -->
                    <form id="delete-form-<?php echo e($currency->id); ?>" action="<?php echo e(route('currency.destroy', $currency->id)); ?>" method="POST" style="display:none;">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Total Currencies: <?php echo e($currencies->total()); ?></small>

        <!-- Pagination Links -->
        <div>
            <?php echo e($currencies->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const currencyId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${currencyId}`).submit();
                }
            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('adminlte::page', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/carlos/LaravelInstall/cgbBudgetAdminLTE/resources/views/currency/index.blade.php ENDPATH**/ ?>