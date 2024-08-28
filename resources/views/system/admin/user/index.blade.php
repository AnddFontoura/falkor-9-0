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
                            <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>
                                        {{ $user->name }}
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @if ($user->email_verified_at)
                                            {{ $user->email_verified_at->format('d/m/Y') }}
                                            <button type="button" class="ml-3 btn btn-danger btn-sm fas fa-trash" data-toggle="modal" data-target="#removeEmailVerificationModal_{{ $user->id }}"></button>
                                            
                                            <!-- Modal de remover verificacao de email -->
                                            <div class="modal fade" id="removeEmailVerificationModal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="removeEmailVerificationModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="removeEmailVerificationModalLabel">VERIFICAR E-MAIL</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Você tem certeza de que deseja REMOVER a verificação do e-mail deste usuário?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form id="form_remove_verified_{{ $user->id }}" action="{{ route('admin.user.removeVerified', [$user->id])}}" method="post">
                                                                @csrf
                                                                @method('PATCH')
                                                                <button onclick="document.getElementById('form_remove_verified_{{ $user->id }}').submit()" class="btn bg-danger color-palette text-decoration-none">Remover verificação</button>
                                                            </form>

                                                            <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <!-------------------------------------------->
                                        @else 
                                            <button type="button" class="btn btn-sm btn-success ml-2" data-toggle="modal" data-target="#emailModal_{{ $user->id }}">
                                                Verificar e-mail
                                            </button>

                                            <!-- Modal de verificar email -->
                                                <div class="modal fade" id="emailModal_{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="emailModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="emailModalLabel">VERIFICAR E-MAIL</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Você tem certeza de que deseja verificar o e-mail deste usuário?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <form id="form_verify_{{ $user->id }}" action="{{ route('admin.user.verify', [$user->id])}}" method="post">
                                                                    @csrf
                                                                    @method('PATCH')
                                                                    <button onclick="document.getElementById('form_verify_{{ $user->id }}').submit()" class="btn bg-success color-palette text-decoration-none">Verificar e-mail</button>
                                                                </form>

                                                                <button type="button" data-dismiss="modal" class="btn btn-secondary">Cancelar</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <!----------------------------->    
                                        @endif
                                    </td>
                                    <!--<td>{{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y') : 'E-mail nao verificado' }}</td>-->
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
                                    <td>
                                        <a href="{{ route('admin.user.show', [$user->id]) }}"><button class='btn btn-sm btn-info' > <i class="fas fa-edit"></i></button></a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>
                @else
                    <div class='alert alert-danger'> Nenhum usuário cadastrado </div>
                @endif
            </div>

            <div class="card-footer"
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
