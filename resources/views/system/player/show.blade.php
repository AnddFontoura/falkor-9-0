@extends('layouts.adminlte')

@section('content_adminlte')

@php
    isset($player->photo) ?
        $bannerPath = asset('storage/' . $player->photo)
        : $bannerPath = asset('img/dragon.png');
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <div class="btn-group">
            <a href="{{ route('system.player.index') }}" class="btn bg-primary"> Listar Jogadores </a>
        </div>
    </div>

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
                            @endif
                        </div>
                    </li>

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
        <div class="card card-primary card-outline">
            <div class="card-body">
                <h1> Em construção </h1>
            </div>
        </div>
    </div>
</div>
@endsection
