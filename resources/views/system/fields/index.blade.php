@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.field.create') }}" class='btn btn-success'> Cadastrar campo </a>
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
                                @foreach ($states as $state)
                                    <option value='{{$state->id}}' {{Request::get('state_id') == $state->id ? 'selected' : ''}}>{{$state->name}}</option>
                                @endforeach
                                
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="fieldCity">Cidade do campo</label>
                            <select class="form-control select2bs4" id="fieldCity" name="city_id">
                                <option value=''>--Selecione uma cidade--</option>
                                @foreach ($cities as $city)
                                    <option value='{{$city->id}}' {{Request::get('city_id') == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" id="searchButton" class="btn btn-primary" value="Filtrar times">
                </div>
            </div>
        </form>
    </div>

    <div id="teste">

    </div>
    
    @if($fields->count() > 0)
        <div class="col-md-12 d-flex flex-column align-items-center">
            <table class="table ">
                <thead class="thead-light">
                    <tr>
                    <th scope="col">Nome</th>
                    <th scope="col">Cidade</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Apelido</th>
                    <th scope="col">Endereco</th>
                    <th scope="col">Como chegar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fields as $field)
                    <tr>
                    <td>{{$field->name}}</td>
                    <td>{{$field->cityInfo->name}}</td>
                    <td>{{$field->cityInfo->stateInfo->name}}</td>
                    <td>{{$field->nickname != ''? $field->nickname : '---'}}</td>
                    <td>{{$field->address}}</td>
                    <td><a href="{{$field->google_location}}">{{$field->google_location}}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($fields->links())
                <div class="col-12 mt-3">
                    {{ $fields->withQueryString()->links() }}
                </div>
            @endif
        </div>
</div>

    @else
        <div class="col-12 mt-3">
            <div class='alert alert-danger'> Nenhum Time cadastrado </div>
        </div>
    @endif
@endsection