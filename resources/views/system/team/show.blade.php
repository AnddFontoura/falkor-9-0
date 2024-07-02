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
    <div class="col-lg-2 col-md-4 col-sm-12 mt-3">
        <a
            href="{{ route('system.team.index') }}"
            class="btn btn-primary w-100"
        >
            Listar Times
        </a>
    </div>

    <div class="col-md-6 col-lg-6 col-sm-12 text-justify mt-3">
        <div class="card">
            <div class="card-header">
                Sobre
            </div>

            <div class="card-body">
                {!! $team->description !!}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-sm-12 text-justify mt-3">
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
