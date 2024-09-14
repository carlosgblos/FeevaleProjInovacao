@extends('adminlte::page')

@section('title', 'Carteiras Compartilhadas')

@section('content_header')
<h1 class="text-primary">Carteiras Compartilhadas</h1>
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<a href="{{ route('walletshared.create') }}" class="btn btn-primary mb-3">Adicionar Nova Compartilhamento de Carteira</a>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Compartilhamentos</h3>
    </div>

    <div class="card-body">
        <table class="table table-sm table-bordered table-hover table-striped">
            <thead>
            <tr>
                <th>Carteira</th>
                <th>Email</th>
                <th>Razão</th>
                <th style="width: 150px;">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($walletSharedTos as $walletSharedTo)
            <tr>
                <td>{{ $walletSharedTo->wallet->description }}</td>
                <td>{{ $walletSharedTo->email }}</td>
                <td>{{ $walletSharedTo->reason }}</td>
                <td>
                    <a href="{{ route('walletshared.edit', $walletSharedTo->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $walletSharedTo->id }}">Excluir</button>
                    <form id="delete-form-{{ $walletSharedTo->id }}" action="{{ route('walletshared.destroy', $walletSharedTo->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between">
        <small class="text-muted">Total Compartilhamentos: {{ $walletSharedTos->total() }}</small>
        <div>{{ $walletSharedTos->links('vendor.pagination.bootstrap-4') }}</div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const walletSharedToId = this.getAttribute('data-id');

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
                    document.getElementById(`delete-form-${walletSharedToId}`).submit();
                }
            });
        });
    });
</script>
@endsection
