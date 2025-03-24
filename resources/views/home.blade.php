@extends('layouts.adminlte')

@section('content_adminlte')
<div class="row">
    @if(count($playerInvitations) > 0)
    <div class="col-md-4 col-lg-3 col-sm-12 mt-3">
        <a href="{{ route('system.player-invitation.index') }}">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Você tem um convite ativo!</h5>
                <p class="btn btn-success"> Algum time te convidou para fazer parte do elenco, clique aqui para avaliar o convite. </p>
            </div>
        </a>
    </div>
    @endif

    @if(count($news) > 0)
        <section class="col-12 border-bottom mt-3">
            <h1>{{ __('news.plural') }}</h1>
        </section>

        @foreach($news as $new)
            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                <div class="card h-100">
                    <div class="card-body">
                        <p class='card-title'>
                            {{ $new->title }}
                        </p>
                    </div>

                    <div class="card-footer">
                        <a
                            href="{{ route('system.news.show', $new->id) }}"
                            class="btn btn-primary w-100"
                        >
                            Abrir noticia
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <section class="col-12 border-bottom mt-3">
        <h1>{{ __('plans.singular') }}</h1>
    </section>

    <div class="col-12 mt-3">
        <div class="card card-outline card-warning">
            <div class="card-body">
                @if($userPlan)
                    <p>
                        Seu plano atual é <strong>{{ $userPlan->planInfo->name }}</strong>
                        e expira <strong>{{ $userPlan->expirationToHuman }}</strong>.
                    </p>
                @else
                    <p>
                        {{ __('plans.no_active_plan') }}
                    </p>
                @endif

                <a
                    href="{{ route('system.plans.form')}}"
                    class="btn btn-primary"
                >
                    {{ __('plans.buttons.see_available_plans') }}
                </a>
            </div>
        </div>
    </div>

    <section class="col-12 border-bottom mt-3">
        <h1>{{ __('teams.teams_i_play_for') }}</h1>
    </section>

    <div class="col-12 mt-3">
        @if(count($playerTeams) == 0)
            <div class="alert alert-danger">
                {{ __('teams.no_team_as_player') }}
            </div>
        @else

            <div class="row">
                @foreach($playerTeams as $teamPlayer)
                    @php
                        isset($teamPlayer->logo_path) ?
                            $logoPath = asset('storage/' . $teamPlayer->logo_path)
                            : $logoPath = asset('img/dragon.png');
                    @endphp
                    <div class="col-md-4 d-flex align-items-stretch mt-3">
                        <div class="card w-100 shadow bg-light color-palette">
                            <div class="card-body mt-3 bg-light color-palette">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12 h-auto"
                                         style="
                                        background-image: url('{{ $logoPath }}');
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                        background-position: center;
                                        min-height: 150px;
                                    ">
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-12 h-auto">
                                        <h3>{{ $teamPlayer->name }}</h3>
                                        <span class="text-muted">
                                        {{ $teamPlayer->cityInfo->name }}
                                        ({{ $teamPlayer->cityInfo->stateInfo->name }})
                                    </span>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer p-1" style="border-top: 0;">
                                <a
                                    href="{{ route('system.team-player.dashboard', [$teamPlayer->team_id]) }}"
                                    class="w-100 btn btn-primary"
                                >
                                    {{ __('players.buttons.player_dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <section class="col-12 border-bottom mt-3">
        <h1>{{ __('teams.teams_i_manage') }}</h1>
    </section>

    <div class="col-12 mt-3">
        @if(count($ownedTeams) == 0)
            <div class="alert alert-danger">
                {{ __('teams.no_teams_created') }}
            </div>
        @else
            <div class="row">
                @foreach($ownedTeams as $ownedTeam)
                    @php
                        isset($ownedTeam->logo_path) && $ownedTeam->logo_path != '' ?
                        $logoPath = asset('storage/' . $ownedTeam->logo_path)
                        : $logoPath = asset('img/dragon.png');

                    @endphp
                    <div class="col-md-4 d-flex align-items-stretch mt-3">
                        <div class="card w-100 shadow bg-light color-palette">
                            <div class="card-body mt-3 bg-light color-palette">
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12 h-auto"
                                         style="
                                        background-image: url('{{ $logoPath }}');
                                        background-size: cover;
                                        background-repeat: no-repeat;
                                        background-position: center;
                                        min-height: 150px;
                                    ">
                                    </div>

                                    <div class="col-md-6 col-lg-6 col-sm-12 h-auto">
                                        <h3>{{ $ownedTeam->name }}</h3>
                                        <span class="text-muted">
                                        {{ $ownedTeam->cityInfo->name }}
                                        ({{ $ownedTeam->cityInfo->stateInfo->name }})
                                    </span>

                                    </div>
                                </div>
                            </div>

                            <div class="card-footer p-1" style="border-top: 0;">
                                <a
                                    href="{{ route('system.team.manage', [$ownedTeam->id]) }}"
                                    class="w-100 btn btn-primary"
                                >
                                    {{ __('teams.buttons.team_dashboard') }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <section class="col-12 border-bottom">
        <h1>{{ __('matches.next_matches') }}</h1>
    </section>

    <div class="col-md-12 mt-3">

        @if(count($nextMatches) == 0)
            <div class="alert alert-danger">
                Você não está em nenhuma partida que acontecerá em breve.
            </div>
        @else
            <div class="row">
                @foreach($nextMatches as $nextMatch)
                    <div class="col-md-4 col-lg-4 col-sm-12 mt-1">
                        <div class="card">
                            <div class="card-body border text-center bg-light">
                                <div class="row">
                                    <div class="col-lg-5 col-md-5 col-sm-6">
                                        {{ $nextMatch->homeTeamInfo->name ?? $nextMatch->home_team_name }}
                                    </div>

                                    <div class="col-lg-2 col-md-2 col-sm-6">
                                        <h1> x </h1>
                                    </div>

                                    <div class="col-lg-5 col-md-5 col-sm-6">
                                        {{ $nextMatch->visitorTeamInfo->name ?? $nextMatch->visitor_team_name }}
                                    </div>

                                    <div class="col-12">
                                        <p class="text-muted">
                                            {{ $nextMatch->schedule->format('d/m/Y')}}
                                            - {{$nextMatch->schedule->format('H:i:s')}}
                                        </p>
                                    </div>

                                    <div class="col-12">
                                        <a href="{{ route('system.matches.show', [0, $nextMatch->match_id]) }}" class="btn btn-primary w-100 p-1">
                                            {{ __('matches.buttons.match_information') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
