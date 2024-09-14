<!-- resources/views/currency/edit.blade.php -->

@extends('adminlte::page')

@section('title', 'Editar Moeda')

@section('content_header')
<h1>Editar Moeda</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Atualizar</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('currency.update', $currency->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" name="description" class="form-control" value="{{ $currency->description }}">
            </div>

            <div class="form-group">
                <label for="abbreviation">Símbolo</label>
                <input type="text" name="abbreviation" class="form-control" value="{{ $currency->abbreviation }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</div>
@endsection
