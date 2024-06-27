@extends('layouts.adminlte')

@section('content_adminlte')
@php
    $bannerPath = asset('img/synthetic_grass.png');
    $logoPath = asset('img/dragon.png');
@endphp
<div class='row'>
    <div class="col-md-6 col-lg-6 col-sm-12 p-1">
        <div class="btn-group">
            <a href="{{ route('system.team.form_update', $team->id) }}" class="btn btn-warning"> Editar time </a>
            <a href="{{ route('system.team-player.form_create', $team->id) }}" class="btn btn-success"> Incluir Jogador </a>
            <a href="{{ route('system.matches.form_create', $team->id) }}" class="btn btn-success"> Incluir Partida </a>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-sm-12 p-1 text-right">
        <div class="btn-group">
            <a href="{{ route('system.team-player.index', $team->id) }}" class="btn btn-primary"> Lista de Jogadores </a>
            <a href="{{ route('system.team.matches', $team->id) }}" class="btn btn-secondary"> Lista de Partidas </a>
            <a href="{{ route('system.team-finance.index', $team->id) }}" class="btn btn-danger"> Financeiro </a>
        </div>
    </div>

    <div class="col-12 p-1">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-1">
                        <h1> Jogadores </h1>
                        @if(count($players) == 0)
                            <div class="alert alert-secondary"> Nenhum jogador cadastrado nesse time </div>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NÚMERO</th>
                                        <th>NOME</th>
                                        <th class="text-center">POSIÇÃO</th>
                                        <th class="text-center">OPÇÕES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($players as $player)
                                    <tr>
                                        <td>
                                            {{ $player->number }}
                                        </td>

                                        <td>
                                            <p class="text-bold"> {{ $player->name }} </p>
                                            <span class="text-muted m-0 p-0"> {{ $player->nickname }} </span>
                                        </td>
                                        <td class="text-center">{!! $player->gamePositionInfo->icon !!}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('system.team-player.form_update', [$team->id, $player->id]) }}" class="btn btn-warning" alt="Editar" title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                                <a href="{{ route('system.team-player.show', [$team->id, $player->id]) }}" class="btn btn-primary" alt="Visualizar" title="Visualizar"> <i class="fas fa-eye"></i> </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="col-md-6 col-lg-6 col-sm-12 mt-1">
                            <h1> Próximos jogos </h1>
                            @if(count($matches) == 0)
                                <div class="alert alert-secondary"> Nenhuma partida para acontecer </div>
                            @else
                                <table class="table table-striped w-100">
                                    <thead>
                                        <tr>
                                            <th>Mandante</th>
                                            <th>x</th>
                                            <th>Visitante</th>
                                            <th class="text-center">OPÇÕES</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($matches as $match)
                                        <tr>
                                            <td> {{ $match->home_team_name }} </td>
                                            <td> x </td>
                                            <td> {{ $match->visitor_team_name }} </td>

                                            <td class="text-center">
                                                <div class="btn-group">
                                                    <a href="{{ route('system.matches.form_update', [$team->id, $match->id]) }}" class="btn btn-warning" alt="Editar" title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                                    <a href="{{ route('system.match-players.form', [$team->id, $match->id]) }}" class="btn btn-secondary" alt="Editar Jogadores" title="Editar Jogadores"> <i class="fas fa-tasks"></i> </a>
                                                    <a href="{{ route('system.matches.show', [$team->id, $match->id]) }}" class="btn btn-primary" alt="Visualizar" title="Visualizar"> <i class="fas fa-eye"></i> </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
