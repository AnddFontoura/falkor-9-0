@extends('layouts.adminlte')

@section('content_adminlte')

@php
    $formUrl = isset($match) ? route('system.matches.update', [$teamId, $match->id]) : route('system.matches.save', $teamId);
    $action = isset($match) ? 'Atualizar' : 'Criar';

    $myTeamIs = old('myTeamIs');
    $enemyTeamId = old('enemyTeamId');
    $enemyTeamName = old('enemyTeamName');
    $myTeamScore = old('myTeamScore');
    $enemyTeamScore = old('enemyTeamScore');
    $championshipName = $match->championship_name ?? old('championshipName');
    $cityId = $match->city_id ?? old('cityId');
    $matchLocation = $match->location ?? old('matchLocation');
    $matchSchedule = $match->schedule ?? old('matchSchedule');
    $selectedHome = '';
    $selectedVisitor = '';

    if ($match) {
        if ($match->home_team_id == $teamId) {
            $myTeamIs = 1;
            $enemyTeamId = $match->visitor_team_id;
            $enemyTeamName = $match->visitor_team_name;
            $enemyTeamScore = $match->visitor_team_score;
            $selectedHome = 'selected';
        } else {
            $myTeamIs = 2;
            $enemyTeamId = $match->home_team_id;
            $enemyTeamName = $match->home_team_name;
            $enemyTeamScore = $match->home_team_score;
            $selectedVisitor = 'selected';
        }
    }
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.matches.index', [$teamId]) }}" class="btn btn-primary"> Listar Partidas </a>
        <a href="{{ route('system.team.manage', [$teamId]) }}" class='btn btn-primary'> Administrar Time </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ $formUrl }}" method="POST">
            @csrf
            <div class="callout callout-success">
                <h1> {{ $action }} Partida </h1>
            </div>
   
            @if ($errors->any())
            <div class="col-12 alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="card">
                <div class="card-header">
                    Dados dos times
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="myTeamIs"> Seu time é </label>
                                <select class="form-control select2bs4" id="myTeamIs" name="myTeamIs">
                                    <option value="1" {{ $selectedHome }}> Mandante </option>
                                    <option value="2" {{ $selectedVisitor }}> Visitante </option>
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="enemyTeamName">Nome do time adversário</label>
                                <input type="text" class="form-control" id="enemyTeamName" name="enemyTeamName" placeholder="Nome do time" value="{{ $enemyTeamName }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="myTeamScore">Gols do seu time</label>
                                <input type="number" class="form-control" id="myTeamScore" name="myTeamScore" placeholder="Gols do seu time" value="{{ $myTeamScore }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="enemyTeamScore">Gols do time adversário</label>
                                <input type="number" class="form-control" id="enemyTeamScore" name="enemyTeamScore" placeholder="Gols do time adversario" value="{{ $enemyTeamScore }}">
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    Data, Hora e Localização
                </div>

                <div class="card-body">
                    <div class="row">
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
                                <label for="matchSchedule">Data e hora do jogo</label>
                                <input type="datetime-local" class="form-control" id="matchSchedule" name="matchSchedule" value="{{ $matchSchedule }}">
                            </div>
                        </div>
                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <label for="matchLocation">Local do Jogo</label>
                                <textarea class="form-control summernote" name="matchLocation" id="matchLocation">{!! $matchLocation !!}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card collapsed-card card-secondary">
                <div class="card-header">
                    Dados de Campeonato
                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i></button>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="championshipName">Nome do Campeonato</label>
                                <input type="text" class="form-control" id="championshipName" name="championshipName" placeholder="Nome do campeonato (se houver)" value="{{ $championshipName }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-3 mb-3 p-0">
                <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} Partida">
            </div>
        </form>
    </div>
</div>
@endsection