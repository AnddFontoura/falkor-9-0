@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        $homeTeamLogo = isset($match->homeTeamInfo->logo_path) ?
            asset('storage/' . $match->homeTeamInfo->logo_path) :
            asset('img/dragon.png');

        $visitorTeamLogo = isset($match->visitorTeamInfo->logo_path) ?
            asset('storage/' . $match->visitorTeamInfo->logo_path) :
            asset('img/dragon.png');

        if ($match->home_score > $match->visitor_score) {
            $bgHome = 'success';
            $bgVisitor = 'danger';
        } else if ($match->visitor_score > $match->home_score) {
            $bgHome = 'danger';
            $bgVisitor = 'success';
        } else {
            $bgHome = 'warning';
            $bgVisitor = 'warning';
        }
    @endphp
    <div class='row'>
        <div class="col-12 mt-3">
            <a href="{{ route('system.matches_wt.index') }}" class="btn btn-primary"> Listar Partidas </a>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-12 mt-3 d-flex align-items-stretch">
            <div class="card text-center">
                <div class="card-header">
                    <h1> MANDANTE </h1>
                </div>

                <div class="card-body">
                    <img class='img w-100' src="{{ $homeTeamLogo }}">
                </div>

                <div class="card-footer bg-{{ $bgHome }}">
                    <h3> {{ $match->home_team_name ?? $match->homeTeamInfo->name }}</h3>
                    <h5> {{ $match->homeTeamInfo->cityInfo->name ?? 'Nd' }} / {{ $match->homeTeamInfo->cityInfo->stateInfo->short ?? 'nd' }}</h5>
                    <h1> {{ $match->home_score ?? 'Sem Resultado' }} </h1>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-6 col-sm-12 mt-3 d-flex align-items-stretch">
            <div class="card text-center">
                <div class="card-header">
                    <h1> VISITANTE </h1>
                </div>

                <div class="card-body">
                    <img class='img w-100' src="{{ $visitorTeamLogo }}">
                </div>

                <div class="card-footer bg-{{ $bgVisitor }}">
                    <h3> {{ $match->visitor_team_name ?? $match->visitorTeamInfo->name }}</h3>
                    <h5> {{ $match->visitorTeamInfo->cityInfo->name ?? 'Nd' }} / {{ $match->visitorTeamInfo->cityInfo->stateInfo->short ?? 'Nd'}}</h5>
                    <h1> {{ $match->visitor_score ?? 'Sem Resultado' }} </h1>
                </div>
            </div>
        </div>

        <div class="col-12 mt-1">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <p>
                                <i class="fas fa-globe m-3"></i>
                                {{ $match->cityInfo->name }}
                                /
                                {{ $match->cityInfo->stateInfo->short }}
                            </p>

                            <p>
                                <i class="fas fa-clock m-3"></i>
                                {{$match->schedule->format('d/m/Y H:i')}}
                            </p>
                        </div>

                        <div class="col-md-6 col-lg-6 col-sm-12">
                            <p class="text-justify"> {!! $match->location !!} </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
