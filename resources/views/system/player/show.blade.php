@extends('layouts.adminlte')

@section('content_adminlte')

@php
$bannerPath = asset('img/dragon.png');

if($player->photo != '') {
$bannerPath = asset('storage/' . $player->photo);
}
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
                    <img class="profile-user-img img-fluid img-circle" src="{{ $bannerPath }}" alt="User profile picture">
                </div>
                <h3 class="profile-username text-center">{{ $player->name }}</h3>
                <p class="text-muted text-center">{{ $player->nickname }}</p>
                <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <i class="fas fa-futbol"></i> <a class="float-right">
                            @if(isset($player->gamePositions))
                                @foreach($player->gamePositions as $gamePosition)
                                    {!! $gamePosition->icon !!}
                                @endforeach
                            @endif
                        </a>
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