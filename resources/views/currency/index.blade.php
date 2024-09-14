<!-- resources/views/currency/index.blade.php -->

@extends('adminlte::page')

@section('title', 'Moedas')

@section('content_header')
<h1 class="text-primary">Moedas</h1>
@endsection

@section('content')
@if (session('success'))
<div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    {{ session('success') }}
</div>
@endif

<a href="{{ route('currency.create') }}" class="btn btn-primary mb-3">Adicionar Novo</a>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista</h3>
    </div>

    <div class="card-body">
        <table class="table table-sm table-bordered table-hover table-striped">
            <thead class="">
            <tr>
                <th>Descrição</th>
                <th style="width: 150px">Símbolo</th>
                <th style="width: 150px">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($currencies as $currency)
            <tr>
                <td>{{ $currency->description }}</td>
                <td>{{ $currency->abbreviation }}</td>
                <td>
                    <a href="{{ route('currency.edit', $currency->id) }}" class="btn btn-warning btn-sm">Editar</a>

                    <!-- Delete button with SweetAlert confirmation -->
                    <button class="btn btn-danger btn-sm btn-delete" data-id="{{ $currency->id }}">Deletar</button>

                    <!-- Hidden form for delete request -->
                    <form id="delete-form-{{ $currency->id }}" action="{{ route('currency.destroy', $currency->id) }}" method="POST" style="display:none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="card-footer d-flex justify-content-between align-items-center">
        <small class="text-muted">Total de Moedas: {{ $currencies->total() }}</small>

        <!-- Pagination Links -->
        <div style: "background-color: white">
            {{ $currencies->links('vendor.pagination.bootstrap-4') }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.querySelectorAll('.btn-delete').forEach(function(button) {
        button.addEventListener('click', function() {
            const currencyId = this.getAttribute('data-id');

            Swal.fire({
                title: 'Confirma ?',
                text: "Confirma Remover Moeda ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, Remova !'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`delete-form-${currencyId}`).submit();
                }
            });
        });
    });
</script>
@endsection
