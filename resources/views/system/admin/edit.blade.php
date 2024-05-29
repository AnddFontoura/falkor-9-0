@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('admin.show', [$user->id]) }}" class="btn btn-primary"> Voltar ao Usuário </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('admin.update', [$user->id]) }}" method="POST">
            @csrf
            @method('patch')
            
            <div class="callout callout-success">
                <h1> {{ $user->name }} </h1>

                <div class="row">
                    @if ($errors->any())
                    <div class="col-12 alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>

                <div class="form-group">
                    <label for="name">Nome</label>
                    <input name="name" type="text" class="form-control" id="name" placeholder="Edite o nome" value="{{ old('name') ?? $user->name }}">
                </div>
                <div class="form-group">
                    <label for="password">Senha</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="{{ old('password') ?? $user->password}}">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Edite o e-mail" value="{{ old('email') ?? $user->email }}">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-check">
                    <input name="is_admin" type="checkbox" class="form-check-input" id="admin">
                    <label class="form-check-label" for="admin">Tornar Administrador</label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Editar dados</button>
            </div>
        </form>
    </div>
</div>
@endsection