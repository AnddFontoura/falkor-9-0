@extends('layouts.adminlte')

@section('content_adminlte')
@php
    $createdData = $user->created_at->format('d-m-Y');
    $updatedData = $user->updated_at->format('d-m-Y');
@endphp

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('admin.index') }}" class="btn btn-primary"> Listar Usuarios </a>
    </div>

    <div class="col-12 mt-3">
        <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info"
                style="
                        background-image: url('');
                        background-position: center;
                        background-size: 100%
                    "
            >
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{ asset('img/avatar.png') }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{ $user->name }}</h5>
                            <span class="description-text text-muted">membro {{ $registeredTime }}</span>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Time</h5>
                            <span class="description-text text-muted">N/A</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-6 text-justify">
        <div class="card">
            <div class="card-header">
                Dados
            </div>

            <div class="card-body">
                <div class="mb-2">
                    E-mail: {{ $user->email }}
                    @if($user->email_verified_at != '')
                        <span class="text-success">E-mail verificado</span>
                    @else
                        <span class="text-danger">E-mail não verificado</span>
                    @endif
                </div>
                <div class="mb-2">
                    Membro desde: {{ $createdData }}
                </div>
                <div class="mb-2">
                    Última atualização: {{ $updatedData != $createdData ? $updatedData : 'Nunca atualizado'}}
                </div>
                <div class="mb-2">
                    Usuário deletado:
                    @if($user->deleted_at != null)
                        <span class="text-danger">{{ $user->deleted_at->format('d-m-Y') }}</span>
                    @else
                        <span class="text-success">Usuário ativo</span>
                    @endif
                </div>
                <div class="mb-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckCheckedDisabled" {{ $user->is_admin == 1 ? 'checked' : ''}} disabled>
                        <label class="form-check-label" for="flexSwitchCheckCheckedDisabled">Administrador</label>
                    </div>
                </div>
                <div class="mt-4">
                    <a class="btn btn-info btn-block" href="{{ route('admin.edit', [$user->id]) }}" role="button">Administrar</a>
                    <p class="text-muted text-center mb-0">Todos os dados podem ser alterados</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 text-justify">
        <div class="card">
            <div class="card-header">
                Informações
            </div>

            <div class="card-body">
                
            </div>
        </div>
    </div>
</div>
@endsection