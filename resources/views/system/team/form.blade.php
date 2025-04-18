@extends('layouts.adminlte')

@section('content_adminlte')

@php
    $formUrl = isset($team) ? route('system.team.update', $team->id) : route('system.team.save');
    $teamName = $team->name ?? old('teamName');
    $teamDescription = $team->description ?? old('teamDescription');
    $cityId = $team->city_id ?? old('cityId');
    $teamModality = $teamModality ?? old('teamModality');
    $foundationDate = $team->foundation_date ?? old('foundationDate');
    $teamYoutube = $team->social_profiles['youtube'] ??  old('teamYoutube');
    $teamInstagram = $team->social_profiles['instagram'] ??  old('teamInstagram');
    $teamX = $team->social_profiles['x'] ??  old('teamX');
    $teamFacebook = $team->social_profiles['facebook'] ??  old('teamFacebook');
    $teamKwai = $team->social_profiles['kwai'] ??  old('teamKwai');
    $teamTiktok = $team->social_profiles['tiktok'] ??  old('teamTiktok');
    $action = isset($team) ? 'Atualizar' : 'Criar'
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> {{ $action }} Time </h1>

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

                    <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamCity">Cidade do time</label>
                            <select class="form-control select2bs4" id="teamCity" name="cityId">
                                @foreach($cities as $city)
                                    @php
                                        $cityId == $city->id ? $select = 'selected' : $select = '';
                                    @endphp

                                    <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamGender">Gênero do time</label>
                            <select class="form-control select2bs4" id="teamGender" name="teamGender">
                                @foreach($teamGender as $key => $value)
                                    @php
                                        $key == ($team->gender ?? null) ? $select = 'selected' : $select = '';
                                    @endphp

                                    <option value="{{ $key }}" {{ $select }}>{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamBirth">Fundação do Time</label>
                            <input type="date" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="modalityId">Modalidade</label>
                            <select class="form-control select2bs4" id="modalityId" name="modalityId">
                                @foreach($modalities as $modality)
                                    @php
                                        isset($team->modality_id) && $team->$modality == $modality->id ? $select = 'selected' : $select = '';
                                    @endphp

                                    <option value="{{ $modality->id }}" {{ $select }}>{{ $modality->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="teamName">Nome do time</label>
                            <input type="text" class="form-control" id="teamName" name="teamName" placeholder="Nome do time" value="{{ $teamName }}">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="teamDescription">Descrição</label>
                            <textarea class="form-control summernote" name="teamDescription" id="teamDescription">{!! $teamDescription !!}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamLogo">Logo do Time</label>
                            <input type="file" class="form-control" id="teamLogo" name="logo">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamBanner">Banner do Time</label>
                            <input type="file" class="form-control" id="teamBanner" name="banner">
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamYoutube">Youtube</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://youtube.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamYoutube"
                                id="teamYoutube"
                                value="{{ $teamYoutube }}"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamFacebook">Facebook</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://facebook.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamFacebook"
                                id="teamFacebook"
                                value="{{ $teamFacebook }}"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamX">X (Antigo Twitter)</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://x.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamX"
                                id="teamX"
                                value="{{ $teamX }}"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamInstagram">Instagram</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://www.instagram.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamInstagram"
                                id="teamInstagram"
                                value="{{ $teamInstagram }}"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamTiktok ">Tiktok</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://tiktok.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamTiktok "
                                id="teamTiktok "
                                value="{{ $teamTiktok }}"
                            >
                        </div>
                    </div>

                    <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                        <label for="teamKwai">Kwai</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text">https://www.kwai.com/</span>
                            </div>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nome no app"
                                name="teamKwai"
                                id="teamKwai"
                                value="{{ $teamKwai }}"
                            >
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} time">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
