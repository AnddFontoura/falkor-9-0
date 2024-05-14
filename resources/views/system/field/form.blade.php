@extends('layouts.adminlte')

@section('content_adminlte')

@php
    $formUrl = isset($field) ? route('system.field.update', $field->id) : route('system.field.save');
    $fieldName = $field->name ?? old('fieldName');
    $fieldNickname = $field->nickname ?? old('fieldNicknamek');
    $fieldAddress = $field->address ?? old('fieldAddress');
    $cityId = $field->city_id ?? old('cityId');
    $action = isset($field) ? 'Atualizar' : 'Criar'
@endphp

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary">Listar campos</a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="callout callout-success">
                <h1> {{ $action }} campo </h1>

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

                    <div class="col-lg-4 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="cityId">Cidade<span class="text-danger">*</span></label>
                            <select class="form-control select2bs4" id="fieldCity" name="cityId">
                                @foreach($cities as $city)
                                    @php 
                                        $select = '';
                                    @endphp
                                    
                                    @if($cityId == $city->id)
                                        @php 
                                            $select = 'selected';
                                        @endphp
                                    @endif
                                <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-4 mt-3">
                        <div class="form-group">
                            <label for="fieldName">Nome do campo<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="fieldName" name="fieldName" placeholder="Nome do campo" value="{{ $fieldName }}" max="254">
                        </div>
                    </div>

                    <div class="col-4 mt-3">
                        <div class="form-group">
                            <label for="fieldNickname">Apelido do campo <span class="text-muted">(opcional)</span></label>
                            <input type="text" class="form-control" id="fieldNickname" name="fieldNickname" placeholder="Apelido do campo" value="{{ $fieldNickname }}" max="254">
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="fieldAddress">Endereço<span class="text-danger">*</span></label>
                            <textarea class="form-control" name="fieldAddress" id="fieldAddress">{{$fieldAddress ?? ''}}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="googleLocation">Como chegar?<span class="text-danger">*</span> <span class='text-muted'>(link do Google Maps)</span></label>
                            <input type="text" class="form-control" name="googleLocation" id="googleLocation"></input>
                        </div>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="fieldPhoto">Foto do Campo <span class="text-muted">(opcional)</span></label>
                            <input type="file" class="form-control" id="fieldPhoto" name="photo">
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} campo">
                    </div>
                </div>      
            </div>
        </form>
    </div>
</div>
@endsection