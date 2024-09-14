
@extends('adminlte::page')

@section('title', 'Editar Carteira')

@section('content_header')
    <h1 class="text-primary">Editar Carteira</h1>
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

    <div class="card card-white">
        <div class="card-body">
            <form action="{{ route('wallet.update', $wallet->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" value="{{ $wallet->description }}" placeholder="Descrição da Carteira">
                </div>

                <div class="form-group">
                    <label for="id_currency">Moeda</label>
                    <select name="id_currency" class="form-control">
                        <option value="">Selecione uma moeda</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}" {{ $wallet->id_currency == $currency->id ? 'selected' : '' }}>
                                {{ $currency->description }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </form>
        </div>
    </div>
@endsection
