@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <div class="btn-group">

            <a href="{{ route('system.team-player.index', $teamId) }}" class="btn btn-primary"> Listar Jogadores </a>
            <a href="{{ route('system.team.manage', $teamId) }}" class="btn bg-purple color-palette"> Administrar Time </a>
        </div>
    </div>

    <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
        @if($player->photo != '')
            @php
                $bannerPath = asset('storage/' . $player->photo);
            @endphp
        @endif
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" src="{{ $bannerPath }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $player->name }}</h3>
                <p class="text-muted text-center">{{ $player->nickname }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <i class="fas fa-list-ol"></i><a class="float-right">{{ $player->number }}</a>
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-futbol"></i> <a class="float-right">{!! $player->gamePositionInfo->icon !!}</a>
                    </li>
                    @if(isset($player->age))
                    <li class="list-group-item">
                        <i class="fas fa-calendar-day"></i> <a class="float-right">{{ $player->age }} anos</a>
                    </li>
                    @endif
                    <li class="list-group-item">
                        <i class="fas fa-arrows-alt-v"></i> <a class="float-right">{{ $player->height }} cm</a>
                    </li>
                    <li class="list-group-item">
                        <i class="fas fa-weight-hanging"></i> <a class="float-right">{{ $player->weight }} Kg</a>
                    </li>

                    <li class="list-group-item">
                        <i class="fas fa-tshirt"></i> <a class="float-right">{{ $player->uniform_size }}</a>
                    </li>

                    <li class="list-group-item">
                        <i class="fas fa-socks"></i> <a class="float-right">{{ $player->foot_size }}</a>
                    </li>

                    <li class="list-group-item">
                        <i class="fas fa-mitten"></i> <a class="float-right">{{ $player->glove_size }}</a>
                    </li>
                </ul>
                <a href="{{ route('system.team-player.form_update', [$teamId, $player->id]) }}" class="btn btn-warning btn-block"> Editar Jogador </a>
            </div>
        </div>
    </div>


    <div class="col-md-9 col-lg-9 col-sm-12 mt-3">
        <div class="card card-primary card-outline">
            <div class="card-body"><h1> Em construção </h1></div>
        </div>
    </div>
</div>
@endsection
