@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('admin.user.show', [$user->id]) }}" class="btn btn-primary"> Voltar ao Usuário </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('admin.user.update', [$user->id]) }}" method="POST">
            @csrf
            @method('patch')

            <div class="callout callout-success">
                <h3> {{ $user->name }} - <span class="text-muted">{{ $user->is_admin ? 'Administrador' : 'Usuário Comum' }}<span> </h3>

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
                    <input name="password" type="password" class="form-control" id="password" placeholder="Password" value="{{ old('password') }}">
                </div>
                <div class="form-group">
                    <label for="password-confirm" class="col-md-4 col-form-label text-md-end">Confirmar senha</label>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" value="">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Edite o e-mail" value="{{ old('email') ?? $user->email }}">
                    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                </div>
                <div class="form-check">
                    <input name="is_admin" type="checkbox" class="form-check-input" id="admin" {{ $user->is_admin ? 'checked' : ''}}>
                    <label class="form-check-label" for="admin" >Tornar Administrador</label>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary mt-3">Salvar dados</button>
                    @if($user->deleted_at == null)
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger mt-3" data-toggle="modal" data-target="#exampleModal">
                            Apagar usuário
                        </button>
                    @else
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info mt-3" data-toggle="modal" data-target="#exampleModal2">
                            Restaurar usuário
                        </button>
                    @endif
                </div>
            </div>
        </form>

            <!-- Modal de delete -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">APAGAR USUÁRIO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Você tem certeza de que deseja apagar este usuário?
                        </div>
                        <div class="modal-footer">
                            <form id="form_delete_{{ $user->id }}" action="{{ route('admin.user.delete', [$user->id]) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button onclick="document.getElementById('form_delete_{{ $user->id }}').submit()" class="btn bg-danger color-palette text-decoration-none">APAGAR USUÁRIO</button>
                            </form>

                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal de restaurar -->
            <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel2">RESTAURAR USUÁRIO</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Você tem certeza de que deseja restaurar este usuário?
                        </div>
                        <div class="modal-footer">
                            <form id="form_restore_{{ $user->id }}" action="{{ route('admin.user.restore', [$user->id]) }}" method="post">
                                @csrf
                                @method('PATCH')
                                <button onclick="document.getElementById('form_restore_{{ $user->id }}').submit()" class="btn bg-success color-palette text-decoration-none">Restaurar usuário</button>
                            </form>

                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
@endsection
