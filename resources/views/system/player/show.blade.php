@extends('layouts.adminlte')

@section('content_adminlte')

@php
    isset($player->photo) ?
        $bannerPath = asset('storage/' . $player->photo)
        : $bannerPath = asset('img/dragon.png');
@endphp
<div class='row'>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-12 mt-3">
                <a
                    href="{{ route('system.player.index') }}"
                    class="btn bg-primary"
                >
                    Listar Jogadores
                </a>
            </div>
        </div>
    </div>

    @if(isset($team) && $team->user_id == $user->id)
        <div class="col-lg-2 col-md-4 col-12 mt-3">
            <a
                href="{{ route('system.team-player.index', $team->id) }}"
                class="btn btn-secondary"
            >
                Listar Jogadores do time
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-12 mt-3">
            <a
                href="{{ route('system.team.manage', $team->id) }}"
                class="btn bg-purple color-palette"
            >
                Administrar Time
            </a>
        </div>

        <div class="col-lg-2 col-md-4 col-12 mt-3">
            <a
                href="{{ route('system.team-player.form_update', [$team->id, $player->id]) }}"
                class="btn btn-warning"
            >
                Editar Jogador
            </a>
        </div>
    @endif

    @if(isset($player->user_id) && isset($player->team_id) && $player->user_id == $user->id)
        <div class="col-lg-2 col-md-4 col-12 mt-3">
            <a
                href="{{ route('system.team-player.update-profile', [$team->id, $player->user_id]) }}"
                class="btn btn-success"
            >
                Clonar perfil
            </a>
        </div>
    @endif

    <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <a href="{{ $bannerPath }}" data-lightbox="playerphoto">
                        <img class="img-fluid" src="{{ $bannerPath }}" alt="User profile picture">
                    </a>
                </div>
                <h3 class="profile-username text-center">{{ $player->name }}</h3>
                <p class="text-muted text-center">{{ $player->nickname }}</p>

                <ul class="list-group list-group-unbordered mb-3">
                    @if(isset($player->modalities))
                        <li class="list-group-item">
                            <i class="fas fa-reply-all"></i>

                            <p class="text-right float-right mb-0">
                                <span class="text-muted"> Modalidades que joga </span>
                            </p>
                            <div class="text-right mb-0 w-100">
                                    @foreach($player->modalities as $modalities)
                                        <span class="btn btn-secondary">
                                            {{ $modalities->name }}
                                        </span>
                                    @endforeach
                            </div>
                        </li>
                    @endif

                    <li class="list-group-item">
                        <i class="fas fa-futbol"></i>

                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Posições que joga </span>
                        </p>
                        <div class="text-right mb-0 w-100">
                            @if(isset($player->gamePositions))
                                @foreach($player->gamePositions as $gamePosition)
                                    {!! $gamePosition->icon !!}
                                @endforeach
                            @elseif(isset($player->gamePositionInfo))
                                {!! $player->gamePositionInfo->icon !!}
                            @endif
                        </div>
                    </li>

                    @if($player->number)
                        <li class="list-group-item">
                            <i class="fas fa-sort-numeric-down"></i>
                            <p class="text-right float-right mb-0">
                                <span class="text-muted"> Número do uniforme </span>
                                <br>
                                {{ $player->number }}
                            </p>
                        </li>
                    @endif

                    @if(isset($player->age))
                    <li class="list-group-item">
                        <i class="fas fa-calendar-day"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Idade </span>
                            <br> {{ $player->age }} anos
                        </p>
                    </li>
                    @endif

                    @if($player->height)
                    <li class="list-group-item">
                        <i class="fas fa-arrows-alt-v"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Altura </span>
                            <br> {{ $player->height }} cm
                        </p>
                    </li>
                    @endif

                    @if($player->weight)
                    <li class="list-group-item">
                        <i class="fas fa-weight-hanging"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Peso </span>
                            <br>
                            {{ $player->weight }} Kg
                        </p>
                    </li>
                    @endif

                    @if($player->uniform_size)
                    <li class="list-group-item">
                        <i class="fas fa-tshirt"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Tamanho do uniforme </span>
                            <br>
                            {{ $player->uniform_size }}
                        </p>
                    </li>
                    @endif

                    @if($player->foot_size)
                    <li class="list-group-item">
                        <i class="fas fa-socks"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Tamanho da chuteira </span>
                            <br>
                            {{ $player->foot_size }}
                        </p>
                    </li>
                    @endif

                    @if($player->glove_size)
                    <li class="list-group-item">
                        <i class="fas fa-mitten"></i>
                        <p class="text-right float-right mb-0">
                            <span class="text-muted"> Tamanho da luva </span>
                            <br>
                            {{ $player->glove_size }}
                        </p>
                    </li>
                    @endif

                    @if($player->city_id)
                        <li class="list-group-item">
                            <i class="fas fa-map"></i>
                            <p class="text-right float-right mb-0">
                                <span class="text-muted"> Cidade em que mora </span>
                                <br> {{ $player->cityInfo->name }} ({{ $player->cityInfo->stateInfo->short }})
                            </p>
                        </li>
                    @endif

                    @if($player->birth_city_id)
                        <li class="list-group-item">
                            <i class="fas fa-map-pin"></i>
                            <p class="text-right float-right mb-0">
                                <span class="text-muted"> Cidade que nasceu </span>
                                <br>{{ $player->birthCityInfo->name }} ({{ $player->birthCityInfo->stateInfo->short }})
                            </p>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>


    <div class="col-md-9 col-lg-9 col-sm-12 mt-3">
        <div class="row">
            @if(isset($player->social_profiles['facebook']) && !empty($player->social_profiles['facebook']))
                <div class="col-md-2 col-sm-6 mt-1">
                    <a
                        class="btn btn-success"
                        target="_blank"
                        href="https://facebook.com {{ $player->social_profiles['facebook'] }}"
                    >
                        Facebook
                    </a>
                </div>
            @endif
        </div>

        <div class="card card-primary card-outline mt-1">
            <div class="card-body">

                <h1> Em construção </h1>
            </div>
        </div>
    </div>
</div>
@endsection
