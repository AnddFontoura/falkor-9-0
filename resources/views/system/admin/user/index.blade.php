@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 p-1">
        <form id="searchForm" action="{{ route('admin.user.index') }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar usuários
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userId">ID</label>
                                <input type="number" class="form-control" id="userId" name="userId" placeholder="Id do usuario" value="{{ Request::get('userId') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userName">Nome</label>
                                <input type="text" class="form-control" id="userName" name="userName" placeholder="Nome do usuario" value="{{ Request::get('userName') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="userEmail">E-mail</label>
                                <input type="text" class="form-control" id="userEmail" name="userEmail" placeholder="Email do Usuario" value="{{ Request::get('userEmail') ?? '' }}">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-check mr-4">
                                <input name="email_verified_at" class="form-check-input" type="checkbox" value="1" id="emailVerifiedCheck">
                                <label class="form-check-label" for="emailVerifiedCheck">
                                    E-mail verificado
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mr-4">
                                <input class="form-check-input" name="deleted_at" type="checkbox" value="1" id="deletedAtCheck">
                                <label class="form-check-label" for="deletedAtCheck">
                                    Deletado
                                </label>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-check mr-4">
                                <input class="form-check-input" name="is_admin" type="checkbox" value="1" id="isAdminCheck">
                                <label class="form-check-label" for="isAdminCheck">
                                    Administrador
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" id="searchButton" class="btn btn-primary" value="Filtrar usuários">
                </div>
            </div>
        </form>
    </div>

    <div class="col-md-12 col-lg-12 col-sm-12">
        <div class="card">
            <div class="card-header">
                <h1>Lista de usuários</h1>
            </div>

            <div class="card-body">
            @if(count($users) > 0)
            <table class="table table-responsive-sm table-striped">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Data de verificação</th>
                    <th scope="col">Criação</th>
                    <th scope="col">Atualização</th>
                    <th scope="col">Deletado</th>
                    <th scope="col">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>
                                <a href="{{ route('admin.user.show', [$user->id]) }}">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y') : 'E-mail nao verificado' }}</td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>{{ $user->updated_at->format('d/m/Y') }}</td>
                            <td>
                                @if($user->deleted_at)
                                    <button class='btn btn-sm btn-danger'> Sim </button>
                                @else
                                    <button class='btn btn-sm btn-success'> Não </button>
                                @endif
                            </td>
                            <td>
                                @if($user->is_admin)
                                    <button class='btn btn-sm btn-success'> Sim </button>
                                @else
                                    <button class='btn btn-sm btn-danger'> Não </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
            <div class="card-footer"
                {{ $users->links() }}
        </div>
                @else
            </div>
                    <div class="col-12 mt-3">
                        <div class='alert alert-danger'> Nenhum usuário cadastrado </div>
                    </div>
            @endif
    </div>
@endsection
