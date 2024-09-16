@extends('adminlte::page')

@section('title', 'Perfil')

@section('content_header')
<h1>Perfil de {{ $user->name }}</h1>
@endsection

@section('content')


<div class="row">
    <div class="col-md-4">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle"
                         src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150' }}"
                         alt="User profile picture">
                </div>

                <h3 class="profile-username text-center">{{ $user->name }}</h3>
                <p class="text-muted text-center">{{ $user->email }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Data de Registro</b> <a class="float-right">{{ $user->created_at->format('d/m/Y') }}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header p-2">
                <h3 class="card-title">Detalhes do Perfil</h3>
            </div>
            <div class="card-body">
                @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
                    </div>

                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>
                    </div>

                    <!-- Password Section -->
                    <h4>Alterar Senha</h4>
                    <div class="form-group">
                        <label for="old_password">Senha Antiga</label>
                        <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Digite a senha antiga">
                    </div>

                    <div class="form-group">
                        <label for="new_password">Nova Senha</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" placeholder="Digite a nova senha">
                    </div>

                    <div class="form-group">
                        <label for="new_password_confirmation">Confirmar Nova Senha</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirme a nova senha">
                    </div>

                    <button type="submit" class="btn btn-primary">Atualizar Perfil</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
