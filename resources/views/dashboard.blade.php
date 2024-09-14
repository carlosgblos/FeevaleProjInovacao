@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
<h1 class="text-primary">Dashboard de Movimentos</h1>
@endsection

@section('content')

<!-- Filter Section -->
<form action="{{ route('home.index') }}" method="GET" class="form-inline mb-4" id="filterForm">
    <div class="form-group mr-3">
        <label for="wallet_id" class="mr-2">Carteira</label>
        <select name="wallet_id" id="wallet_id" class="form-control">
            <option value="">Todas</option>
            @foreach($wallets as $wallet)
            <option value="{{ $wallet->id }}" {{ request()->get('wallet_id') == $wallet->id ? 'selected' : '' }}>
                {{ $wallet->description }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="movement_type_id" class="mr-2">Tipo de Movimento</label>
        <select name="movement_type_id" id="movement_type_id" class="form-control">
            <option value="">Todos</option>
            @foreach($movementTypes as $type)
            <option value="{{ $type->id }}" {{ request()->get('movement_type_id') == $type->id ? 'selected' : '' }}>
                {{ $type->description }}
            </option>
            @endforeach
        </select>
    </div>

    <div class="form-group mr-3">
        <label for="description" class="mr-2">Descrição</label>
        <input type="text" name="description" id="description" class="form-control" placeholder="Descrição do Movimento" value="{{ request()->get('description') }}">
    </div>

    <div class="form-group mr-5">
        <label for="date_range" class="mr-2">Período</label>
        <input type="text" name="date_range" id="date_range" style="width: 200px" class="form-control" placeholder="Selecionar Período" value="{{ request()->get('date_range') }}">
    </div>

    <button type="submit" class="btn btn-primary">Filtrar</button>
</form>

<!-- Add a div to hold the charts and the table -->
<div id="dashboard-content">

    <div class="row">
        @foreach($walletBalances as $wallet)
        <div class="col-md-3">
            <div class="info-box {{ $wallet['balance'] >= 0 ? 'bg-success' : 'bg-danger' }}">
                <span class="info-box-icon"><i class="fas fa-wallet"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">{{ $wallet['description'] }}</span>
                    <span class="info-box-number">{{ number_format($wallet['balance'], 2, ',', '.') }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transações de Crédito por Tipo de Movimento</h3>
                </div>
                <div class="card-body">
                    <canvas id="creditChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Transações de Débito por Tipo de Movimento</h3>
                </div>
                <div class="card-body">
                    <canvas id="debitChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Saldo Atual vs Movimentos Futuros</h3>
                </div>
                <div class="card-body">
                    <canvas id="balancePieChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-9">
            <div class="card">
                <div class="card-header">
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
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($movements as $movement)
                        <tr>
                            <td>{{ $movement->description }}</td>
                            <td>{{ number_format($movement->vlr, 2, ',', '.') }}</td>
                            <td>{{ $movement->transaction_at }}</td>
                            <td>{{ $movement->transaction_type == 'C' ? 'Crédito' : 'Débito' }}</td>
                            <td>{{ $movement->wallet->description }}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


</div>

@endsection

@section('scripts')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<script>
    // Initialize the date range picker
    $('#date_range').daterangepicker({
        locale: {
            format: 'DD/MM/YYYY'
        },
        startDate: moment().subtract(30, 'days'),  // 30 days ago from today
        endDate: moment().endOf('month')           // End of the current month

    });


    var creditCtx = document.getElementById('creditChart').getContext('2d');
    var debitCtx = document.getElementById('debitChart').getContext('2d');

    // Crédito Bar Chart
    var creditChart = new Chart(creditCtx, {
        type: 'bar',
        data: {
            labels: @json($creditLabels), // Movement types for credits
            datasets: [{
                label: 'Crédito',
                data: @json($creditValues), // Credit amounts per movement type
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        }
    });

    // Débito Bar Chart
    var debitChart = new Chart(debitCtx, {
        type: 'bar',
        data: {
            labels: @json($debitLabels), // Movement types for debits
            datasets: [{
                label: 'Débito',
                data: @json($debitValues), // Debit amounts per movement type
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        }
    });

    var balanceCtx = document.getElementById('balancePieChart').getContext('2d');

    var balancePieChart = new Chart(balanceCtx, {
        type: 'pie',
        data: {
            labels: ['Saldo Atual', 'Movimentos Futuros'],
            datasets: [{
                data: @json([$completedBalance, $futureBalance]),
                backgroundColor: ['#4CAF50', '#FFC107'],
                borderWidth: 1
            }]
        }
    });

</script>
@endsection
