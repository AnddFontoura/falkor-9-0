@extends('layouts.adminlte')

@section('content_adminlte')

<div class="row">
    @if(count($playerInvitations) > 0)
    <div class="col-md-4 col-lg-3 col-sm-12 mt-3 p-1">
        <a href="{{ route('system.player-invitation.index') }}">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Você tem um convite ativo!</h5>
                <p class="btn btn-success"> Algum time te convidou para fazer parte do elenco, clique aqui para avaliar o convite. </p>
            </div>
        </a>
    </div>
    @endif
</div>

<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1 class="m-0">Dashboard</h1>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-warning">
        <div class="card-body">
            @if($userPlan)
                <p>
                    Seu plano atual é <strong>{{ $userPlan->planInfo->name }}</strong>
                    e expira <strong>{{ $userPlan->expirationToHuman }}</strong>.
                </p>
            @else
                <p>
                    Você não tem um plano ativo.
                </p>
            @endif

            <a href="{{ route('system.plans.form')}}" class="btn btn-primary"> Conheça nossos planos </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times que eu jogo</h2>
                    <div class="card-tools">
                        <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row">
                        <div class="row">
                        @foreach($playerTeams as $teamPlayer)
                            @php
                                isset($teamPlayer->teamInfo->logo_path) ?
                                    $logoPath = asset('storage/' . $teamPlayer->teamInfo->logo_path)
                                    : $logoPath = asset('img/dragon.png');
                            @endphp

                            <div class="col-md-4 col-lg-4 col-sm-12 mt-1">
                                <div class="card">
                                    <div class="card-header" style="cursor:pointer;">
                                        <figure class="d-flex justify-content-center">
                                            <img style="height:120px" class="img-fluid" src="{{ $logoPath }}">
                                        </figure>
                                    </div>
                                    <div id="team-player-{{ $teamPlayer->id }}" class="card-body border text-center bg-light">
                                        <h4 class="text-info"><a href="{{ route('system.team.show', [$teamPlayer->team_id]) }}">{{ $teamPlayer->teamInfo->name }}</a></h4>
                                        <div>
                                            <span class="text-bold">Posição</span>: {{ $teamPlayer->gamePositionInfo->name }}
                                        </div>
                                        <div>
                                            <span class="text-bold">Número da camisa</span>: {{ $teamPlayer->number }}
                                        </div>
                                        <div>
                                            <span class="text-bold">Ativo</span>:
                                                @if($teamPlayer->active)
                                                    <span class="text-success">Sim</span>
                                                @else
                                                    <span class="text-danger">Não</span>
                                                @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times que eu administro</h2>
                    <div class="card-tools">
                    <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                    <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="row">
                        @foreach($ownedTeams as $ownedTeam)
                            @php
                                isset($ownedTeam->logo_path) && $ownedTeam->logo_path != '' ?
                                $logoPath = asset('storage/' . $ownedTeam->logo_path)
                                : $logoPath = asset('img/dragon.png');

                            @endphp
                            <div class="col-md-4 col-lg-4 col-sm-12 mt-1">
                                <div class="card">
                                    <div class="card-header" style="cursor:pointer;">
                                        <figure class="d-flex justify-content-center">
                                            <img style="height:120px" class="img-fluid" src="{{ $logoPath }}">
                                        </figure>
                                    </div>
                                    <div class="card-body border text-center bg-light">
                                        <h4 class="text-info"><a href="{{ route('system.team.show', [$ownedTeam->id]) }}">{{ $ownedTeam->name }}</a></h4>
                                    </div>
                                </div>
                            </div>
                          @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0 bg-success">
                <h2 class="card-title">Próximas partidas</h2>
                <div class="card-tools">
                    <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column flex-wrap">
                    @foreach($nextMatches as $nextMatch)
                        @php
                            $myTeam = $nextMatch->homeTeamInfo != null ?
                                $nextMatch->homeTeamInfo :
                                $nextMatch->visitorTeamInfo;

                            $isVisitant = $nextMatch->homeTeamInfo == null;
                            $opposingTeam = $isVisitant ? $nextMatch->home_team_name : $nextMatch->visitor_team_name;

                            $myTeamLogo = isset($myTeam->logo_path) ?
                                asset('storage/' . $myTeam->logo_path)
                                : asset('img/dragon.png');
                        @endphp
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" style="cursor:pointer;">
                                    <div class="d-flex flex-column align-items-center">
                                        <div class="d-flex align-items-center">
                                            <div class="d-flex col-5">
                                                <figure class="w-25 mx-auto">
                                                    <img style="height:50px" class="img-fluid" src="{{ $myTeamLogo }}">
                                                </figure>
                                            </div>
                                            <div class="h1 col-2 text-center">x</div>
                                            <div class="d-flex col-5">
                                                <figure class="w-25 mx-auto mt-2">
                                                    <img class="img-fluid" src="{{ asset('img/dragon.png') }}">
                                                </figure>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body border text-center bg-light">
                                    <h4>{{ $nextMatch->schedule->format('d/m/Y')}} - {{$nextMatch->schedule->format('H:i:s')}}</h4>
                                    <div class="d-flex justify-content-center">
                                        <span class="text-bold mr-1">Endereço:</span> {!! $nextMatch->location !!}
                                    </div>
                                    <div class="text-muted text-bold">
                                        {{ $isVisitant ? 'Visitante' : 'Mandante'}}
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex justify-content-between w-100">
                                            <div class="text-info text-bold">
                                                {{ $myTeam->name }}
                                            </div>
                                            <div class="text-danger text-bold">
                                                {{ $opposingTeam }}
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
