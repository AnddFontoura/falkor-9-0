@extends('layouts.adminlte')

@section('content_adminlte')
@php
    $bannerPath = asset('img/synthetic_grass.png');
    $logoPath = asset('img/dragon.png');
@endphp
<div class='row'>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.form_update', $team->id) }}"
                    class="btn btn-success w-100"
                >
                    Editar time
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team-finance.index', $team->id) }}"
                    class="btn btn-danger w-100"
                >
                    Financeiro
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team-player.index', $team->id) }}"
                    class="btn btn-primary w-100"
                >
                    Lista de Jogadores
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.matches', $team->id) }}"
                    class="btn btn-secondary w-100"
                >
                    Lista de Partidas
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.friendly-games', $team->id) }}"
                    class="btn btn-info w-100"
                >
                    Amistosos
                </a>
            </div>
        </div>
    </div>


    <div class="col-12 p-1 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-1">
                        <h1> Informações rápidas </h1>

                        @if ($newPlayers > 0)
                            <a href="{{ route('system.team.players-applications', $teamId) }}" class="alert alert-danger">
                                Você tem {{ $newPlayers }} aguardando aprovação para fazer parte do time.
                            </a>
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
