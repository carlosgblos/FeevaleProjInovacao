<!-- resources/views/currency/create.blade.php -->

@extends('adminlte::page')

@section('title', 'Add Currency')

@section('content_header')
<h1>Add New Currency</h1>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Nova Moeda</h3>
    </div>

    <div class="card-body">
        <form action="{{ route('currency.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="description">Descrição</label>
                <input type="text" name="description" class="form-control" placeholder="Enter description">
            </div>

            <div class="form-group">
                <label for="abbreviation">Símbolo</label>
                <input type="text" name="abbreviation" class="form-control" placeholder="Enter abbreviation" required>
            </div>

            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>
</div>
@endsection
