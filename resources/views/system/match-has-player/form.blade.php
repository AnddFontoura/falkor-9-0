@extends('layouts.adminlte')

@section('content_adminlte')

@php

@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.matches.index', [$team->id]) }}" class="btn btn-primary"> Listar Partidas </a>
        <a href="{{ route('system.team.manage', [$team->id]) }}" class="btn btn-primary"> Administar time </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.match-players.update', [$team->id, $match->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> Jogadores </h1>        
            </div>

            @foreach($teamPlayers as $player)
            <div class="callout callout-success">
                <h1> Jogadores </h1>        
            </div>
            @endforeach
        </form>
    </div>
</div>
@endsection