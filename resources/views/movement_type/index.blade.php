
@extends('adminlte::page')

@section('title', 'Tipos de Movimento')

@section('content_header')
    <h1 class="text-primary">Tipos de Movimento</h1>
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

    <a href="{{ route('movement_type.create') }}" class="btn btn-primary mb-3">Adicionar Novo Tipo de Movimento</a>

    <div class="card">
        <div class="card-header"> <!-- No additional class -->
            <h3 class="card-title">Lista de Tipos de Movimento</h3>
        </div>

        <div class="card-body">
            <table class="table table-sm table-bordered table-hover table-striped">
                <thead> <!-- No class -->
                    <tr>
                        <th>Descrição</th>
                        <th style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($movementTypes as $movementType)
                        <tr>
                            <td>{{ $movementType->description }}</td>
                            <td>
                                <a href="{{ route('movement_type.edit', $movementType->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $movementType->id }}">Excluir</button>
                                <form id="delete-form-{{ $movementType->id }}" action="{{ route('movement_type.destroy', $movementType->id) }}" method="POST" style="display:none;">
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
            <small class="text-muted">Total Tipos de Movimento: {{ $movementTypes->total() }}</small>
            <div>{{ $movementTypes->links('vendor.pagination.bootstrap-4') }}</div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function() {
                const movementTypeId = this.getAttribute('data-id');
                
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
                        document.getElementById(`delete-form-${movementTypeId}`).submit();
                    }
                });
            });
        });
    </script>
@endsection
