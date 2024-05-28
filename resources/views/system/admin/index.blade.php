@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.field.form_create') }}" class='btn btn-success'>  </a>
    </div>

    <div class="col-12 p-1">
        <form id="searchForm" action="{{ route('system.field.index') }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar campos
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="fieldName">Nome do campo</label>
                                <input type="text" class="form-control" id="fieldName" name="fieldName" placeholder="Nome do campo" value="{{ Request::get('fieldName') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="fieldState">Estado do campo</label>
                            <select class="form-control select2bs4" id="fieldState" name="state_id">
                                <option value=''>--Selecione um estado--</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="fieldCity">Cidade do campo</label>
                            <select class="form-control select2bs4" id="fieldCity" name="city_id">
                                <option value=''>--Selecione uma cidade--</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" id="searchButton" class="btn btn-primary" value="Filtrar campos">
                </div>
            </div>
        </form> 
    </div>
        
    <div class="col-md-12 d-flex align-items-stretch">
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nome</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Data de verificação</th>
                    <th scope="col">Criado em</th>
                    <th scope="col">Atualizado em</th>
                    <th scope="col">Admin</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->email_verified_at }}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{{ $user->is_admin == 1 ? 'Sim' : 'Nao' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
    </div>

    <div class="col-12 mt-3">
        <div class='alert alert-danger'> Nenhum Time cadastrado </div>
    </div>

@endsection