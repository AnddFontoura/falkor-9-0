@extends('layouts.adminlte')

@section('content_adminlte')

@php
$formUrl = isset($match) ? route('system.matches.update', [$teamId, $match->id]) : route('system.matches.save', $teamId);
$teamName = $team->name ?? old('teamName');
$teamDescription = $team->description ?? old('teamDescription');
$foundationDate = $team->foundation_date ?? old('foundationDate');
$action = isset($match) ? 'Atualizar' : 'Criar';


$myTeamIs = old('myTeamIs');
$enemyTeamId = old('enemyTeamId');
$enemyTeamName = old('enemyTeamName');
$myTeamScore = old('myTeamScore');
$enemyTeamScore = old('enemyTeamScore');
$championshipName = $match->championship_name ?? old('championshipName');
$cityId = $match->city_id ?? old('cityId');
$matchLocation = $match->location ?? old('matchLocation');
$matchSchedule = '';

if ($match) {

}

@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.matches.index', [$teamId]) }}" class="btn btn-primary"> Listar Partidas </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> {{ $action }} Partida </h1>

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

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamCity">Cidade da partida</label>
                            <select class="form-control select2bs4" id="teamCity" name="cityId">
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

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamCity"> Seu time é </label>
                            <select class="form-control select2bs4" id="teamCity" name="cityId">
                                <option value="1"> Mandante </option>
                                <option value="2"> Visitante </option>
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="championshipName">Nome do Campeonato</label>
                            <input type="text" class="form-control" id="championshipName" name="championshipName" placeholder="Nome do time" value="{{ $championshipName }}">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="enemyTeamName">Nome do time adversário</label>
                            <input type="text" class="form-control" id="enemyTeamName" name="enemyTeamName" placeholder="Nome do time" value="{{ $enemyTeamName }}">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="matchLocation">Local do Jogo</label>
                            <textarea class="form-control summernote" name="matchLocation" id="matchLocation">{!! $matchLocation !!}</textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamBanner">Data e hora do jogo</label>
                            <input type="datetime-local" class="form-control" id="teamBanner" name="banner">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} Partida">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection