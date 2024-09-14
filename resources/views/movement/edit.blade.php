
@extends('adminlte::page')

@section('title', 'Editar Movimento')

@section('content_header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <h1 class="text-primary">Editar Movimento</h1>
@endsection
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
@section('content')
    <form action="{{ route('movement.update', $movement->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="id_wallet">Carteira</label>
                    <select name="id_wallet" id="wallet_id" class="form-control" onchange="loadMovementTypes()">
                        @foreach ($wallets as $wallet)
                            <option value="{{ $wallet->id }}" {{ $movement->id_wallet == $wallet->id ? 'selected' : '' }}>{{ $wallet->description }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_movement_type">Tipo de Movimento</label>
                    <select name="id_movement_type" id="movement_type_id" class="form-control">
                        @foreach ($movementTypes as $type)
                        <option value="{{ $type->id }}" {{ $movement->id_movement_type == $type->id ? 'selected' : '' }}>
                            {{ $type->description }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" value="{{ $movement->description }}" placeholder="Descrição do Movimento">
                </div>

                <div class="form-group">
                    <label for="transaction_type">Tipo de Transação</label>
                    <select name="transaction_type" class="form-control">
                        <option value="C" {{ $movement->transaction_type == 'C' ? 'selected' : '' }}>Crédito</option>
                        <option value="D" {{ $movement->transaction_type == 'D' ? 'selected' : '' }}>Débito</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="vlr">Valor</label>
                    <input type="text" name="vlr" id="vlr" class="form-control" value="{{ number_format($movement->vlr, 2, ',', '.') }}" placeholder="Valor">
                </div>

                <div class="form-group">
                    <label for="transaction_at">Data da Transação</label>
                    <input type="text" name="transaction_at" id="transaction_at" class="form-control" value="{{ $movement->transaction_at }}" placeholder="Data da Transação">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
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
            locale: "pt",            // Locale for Portuguese formatting
            enableTime: false
        });
    </script>
@endsection
