
@extends('adminlte::page')

@section('title', 'Carteiras')

@section('content_header')
    <h1 class="text-primary">Carteiras</h1>
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

    <a href="{{ route('wallet.create') }}" class="btn btn-primary mb-3">Adicionar Nova Carteira</a>

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
                    @foreach ($wallets as $wallet)
                        <tr>
                            <td>{{ $wallet->description }}</td>
                            <td>{{ $wallet->currency->description ?? 'N/A' }}</td>
                            <td>
                                @if ($wallet->id_owner == auth()->id())
                                    <a href="{{ route('wallet.edit', $wallet->id) }}" class="btn btn-warning btn-sm">Editar</a>
                                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $wallet->id }}">Excluir</button>
                                    <form id="delete-form-{{ $wallet->id }}" action="{{ route('wallet.destroy', $wallet->id) }}" method="POST" style="display:none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    @else
                                    <span class="text-muted">Sem permissão</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer d-flex justify-content-between">
            <small class="text-muted">Total Carteiras: {{ $wallets->total() }}</small>
            <div>{{ $wallets->links('vendor.pagination.bootstrap-4') }}</div>
        </div>
    </div>
@endsection

@section('scripts')
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
@endsection
