
@extends('adminlte::page')

@section('title', 'Adicionar Nova Carteira')

@section('content_header')
    <h1 class="text-primary">Adicionar Nova Carteira</h1>
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
            <form action="{{ route('wallet.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" placeholder="Descrição da Carteira">
                </div>

                <div class="form-group">
                    <label for="id_currency">Moeda</label>
                    <select name="id_currency" class="form-control">
                        <option value="">Selecione uma moeda</option>
                        @foreach ($currencies as $currency)
                            <option value="{{ $currency->id }}">{{ $currency->description }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </form>
        </div>
    </div>
@endsection
