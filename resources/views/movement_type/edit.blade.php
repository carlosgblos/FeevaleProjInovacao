
@extends('adminlte::page')

@section('title', 'Editar Tipo de Movimento')

@section('content_header')
    <h1 class="text-primary">Editar Tipo de Movimento</h1>
@endsection

@section('content')
    <form action="{{ route('movement_type.update', $movementType->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label for="description">Descrição</label>
                    <input type="text" name="description" class="form-control" value="{{ $movementType->description }}" placeholder="Descrição do Tipo de Movimento">
                </div>

                <button type="submit" class="btn btn-primary">Salvar</button>
            </div>
        </div>
    </form>
@endsection
