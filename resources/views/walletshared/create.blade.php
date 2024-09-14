@extends('adminlte::page')

@section('title', 'Adicionar Novo Compartilhamento')

@section('content_header')
<h1 class="text-primary">Adicionar Novo Compartilhamento de Carteira</h1>
@endsection

@section('content')
<form action="{{ route('walletshared.store') }}" method="POST">
    @csrf
    <div class="card">
        <div class="card-body">
            <div class="form-group">
                <label for="wallet_id">Carteira</label>
                <select name="wallet_id" class="form-control">
                    @foreach ($wallets as $wallet)
                    <option value="{{ $wallet->id }}">{{ $wallet->description }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email para Compartilhamento">
            </div>

            <div class="form-group">
                <label for="reason">Razão</label>
                <textarea name="reason" class="form-control" placeholder="Razão para o Compartilhamento"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar</button>
        </div>
    </div>
</form>
@endsection
