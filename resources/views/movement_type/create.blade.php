
@extends('adminlte::page')

@section('title', 'Adicionar Novo Tipo de Movimento')

@section('content_header')
    <h1 class="text-primary">Adicionar Novo Tipo de Movimento</h1>
@endsection

@section('content')
    <form action="{{ route('movement_type.store') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" placeholder="Descrição do Tipo de Movimento">
                </div>

                <button type="submit" class="btn btn-primary">Adicionar</button>
            </div>
        </div>
    </form>
@endsection
