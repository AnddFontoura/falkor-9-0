@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.field.form_create') }}" class='btn btn-success'> Cadastrar campo </a>
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
                                    <option value='{{$city->id}}' {{Request::get('city_id') == $city->id ? 'selected' : ''}}>{{$city->name}}({{$city->stateInfo->short}})</option>
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
    
    @if($fields->count() > 0)

            @foreach($fields as $field)

            @php
                $fieldPhotoPath = null;
                
                if($field->photos->isNotEmpty()) {
                    $fieldPhotoPath = 'storage/' . $field->photos->first()->photo;
                }
            @endphp
            
            <div class="col-md-4 d-flex align-items-stretch">
                <div class="card w-100 card-widget widget-user shadow bg-light color-palette">
                    <div class="widget-user-header" style="background-image: url('{{ asset(ltrim($fieldPhotoPath, '/')) }}')">
                        <div class="widget-user-username">
                            <h3>{{ $field->name }}</h3>
                        </div>
                    </div>
                    <div class="widget-user-image">
                        <img class="elevation-2" src="" alt="Team Logo">
                    </div>
            <div class="card-footer bg-light color-palette">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Cidade</h5>
                            <span class="description-text">{{ $field->cityInfo->name }} </span>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Estado</h5>
                            <span class="description-text">{{ $field->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="description-block border-top less-height">
                            <div class="btn-group mt-3">
                                <a href="{{ route('system.field.show', [$field->id]) }}" class="btn btn-primary"> Visualizar </a>
                                <a href="{{ route('system.field.manage', [$field->id]) }}" class="btn bg-purple color-palette"> Administrar </a>
                                <form method="POST" id="form_delete_{{ $field->id }}" action="{{ route('system.field.delete', [$field->id]) }}">
                                @csrf
                                @method('DELETE')
                                <a href="#" onclick="document.getElementById('form_delete_{{ $field->id }}').submit()" class="btn bg-danger color-palette"> Excluir(teste) </a>
                                </form>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach

            @if($fields->links())
                <div class="col-12 mt-3 d-flex justify-content-center">
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