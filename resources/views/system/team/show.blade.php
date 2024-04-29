@extends('layouts.adminlte')

@section('content_adminlte')

@php
    isset($team->logo_path) ?
        $logoPath = asset('storage/' . $team->logo_path)
        : $logoPath = asset('img/dragon.png');

    isset($team->banner_path) ?
        $bannerPath = asset('storage/' . $team->banner_path)
        : $bannerPath = asset('img/synthetic_grass.png');
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
    </div>

    <div class="col-12 mt-3">
        <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info"
                style="
                        background-image: url('{{ $bannerPath }}');
                        background-position: center;
                        background-size: 100%
                    "
            >
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="{{ $logoPath }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{ $team->name }}</h5>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">{{ $team->cityInfo->name }}</h5>
                            <span class="description-text">{{ $team->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-6 text-justify">
        <div class="card">
            <div class="card-header">
                Sobre
            </div>

            <div class="card-body">
                {!! $team->description !!}
            </div>
        </div>
    </div>

    <div class="col-6 text-justify">
        @if(count($teamPlayers) > 0)
        <div class="card">
            <div class="card-header">
                Jogadores
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                @foreach($teamPlayers as $player)
                    <tr>
                        <td class='w-10'> {{ $player->number }} </td>
                        <td class='w-10'> {!! $player->gamePositionInfo->icon !!} </td>
                        <td> {{ $player->name }} </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection