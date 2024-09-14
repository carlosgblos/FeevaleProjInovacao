@extends('adminlte::page')

@section('title', 'Movimentos')

@section('content_header')
<h1 class="text-primary">Movimentos</h1>
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
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<a href="{{ route('movement.create') }}" class="btn btn-primary mb-3">Adicionar Novo Movimento</a>

<!-- Filter Form -->
<form action="{{ route('movement.index') }}" method="GET" class="form-inline mb-4">
    <div class="form-group mr-3">
        <label for="description" class="mr-2">Descrição do Movimento</label>
        <input type="text" name="description" id="description" class="form-control" placeholder="Descrição do Movimento" value="{{ request()->get('description') }}">
    </div>

    <div class="form-group mr-3">
        <label for="id_movement_type" class="mr-2">Tipo de Movimento</label>
        <select name="id_movement_type" id="id_movement_type" class="form-control">
            <option value="">Todos</option>
            @foreach($movementTypes as $type)
            <option value="{{ $type->id }}" {{ request()->get('id_movement_type') == $type->id ? 'selected' : '' }}>
                {{ $type->description }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="transaction_at_start" class="mr-2">Data Início</label>
        <input type="text" name="transaction_at_start" id="transaction_at_start" class="form-control" placeholder="Data Início" value="{{ request()->get('transaction_at_start') }}">
    </div>

    <div class="form-group mr-3">
        <label for="transaction_at_end" class="mr-2">Data Fim</label>
        <input type="text" name="transaction_at_end" id="transaction_at_end" class="form-control" placeholder="Data Fim" value="{{ request()->get('transaction_at_end') }}">
    </div>

    <div class="form-group mr-3">
        <label for="wallet" class="mr-2">Carteira</label>
        <select name="wallet_id" id="wallet" class="form-control">
            <option value="">Todas</option>
            @foreach($wallets as $wallet)
            <option value="{{ $wallet->id }}" {{ request()->get('wallet_id') == $wallet->id ? 'selected' : '' }}>
                {{ $wallet->description }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="transaction_type" class="mr-2">Tipo de Transação</label>
        <select name="transaction_type" id="transaction_type" class="form-control">
            <option value="">Todos</option>
            <option value="C" {{ request()->get('transaction_type') == 'C' ? 'selected' : '' }}>Crédito</option>
            <option value="D" {{ request()->get('transaction_type') == 'D' ? 'selected' : '' }}>Débito</option>
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
            @foreach ($movements as $movement)
            <tr>
                <td>{{ $movement->description }}</td>
                <td>{{ number_format($movement->vlr, 2, ',', '.') }}</td>
                <td>{{ $movement->transaction_at->format('d/m/Y') }}</td>
                <td>{{ $movement->transaction_type == 'C' ? 'Crédito' : 'Débito' }}</td>
                <td>{{ $movement->wallet->description }}</td>
                <td>
                    <a href="{{ route('movement.edit', $movement->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $movement->id }}">Excluir</button>
                    <form id="delete-form-{{ $movement->id }}" action="{{ route('movement.destroy', $movement->id) }}" method="POST" style="display:none;">
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
        <small class="text-muted">Total Movimentos: {{ $movements->total() }}</small>
        <div>{{ $movements->links('vendor.pagination.bootstrap-4') }}</div>
    </div>
</div>
@endsection

@section('scripts')
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
@endsection
