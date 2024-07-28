@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.team.manage', [$team->id]) }}"
                        class="btn bg-purple color-palette w-100"
                    >
                        Administrar Time
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ route('system.team.friendly-games', $team->id) }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar amistosos
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="matchDate">Data do jogo</label>
                                    <input
                                        type="date"
                                        class="form-control"
                                        id="matchDate"
                                        name="matchDate"
                                        placeholder="Data do Amistoso"
                                        value="{{ Request::get('matchDate') ?? '' }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Filtrar amistosos">
                    </div>
                </div>
            </form>
        </div>

        @if(count($ownFriendlyGames) == 0)
            <div class="col-12 mt-3">
                <div class='alert alert-danger'> Nenhuma partida cadastrada </div>
            </div>
        @else
            @foreach($ownFriendlyGames as $friendlyGame)@php
                isset($friendlyGame->teamInfo->logo_path) ?
                    $logoPath = asset('storage/' . $friendlyGame->teamInfo->logo_path)
                    : $logoPath = asset('img/dragon.png');

            @endphp

            <div class="col-md-6 col-lg-6 col-sm-12 col-xl-4 d-flex align-items-stretch mt-3">
                <div class="card w-100 shadow bg-light color-palette">
                    <div class="card-header text-center">
                        {{ $friendlyGame->teamInfo->name }}
                    </div>
                    <div class="card-body bg-light color-palette">
                        <div class="row">
                            <div class="col-md-12"
                                 style="
                                            height: 100px;
                                            background-image: url('{{ $logoPath }}');
                                            background-size: cover;
                                            background-repeat: no-repeat;
                                            background-position: center;
                                            min-height: 150px;
                                        ">
                            </div>

                            <div class="col-12 mt-1 h-auto">
                                <h5> Cidade do amistoso</h5>
                                <p class="text-muted">
                                    {{ $friendlyGame->cityInfo->name }}
                                    ({{ $friendlyGame->cityInfo->stateInfo->name }})
                                </p>
                                <h5> Data/Hora </h5>
                                <p class="text-muted">
                                    {{ $friendlyGame->match_date->format('d/m/Y') }} -
                                    {{ $friendlyGame->start_at }}
                                </p>
                                <h5> Modalidade </h5>
                                <p class="text-muted">
                                    {{ $friendlyGame->teamInfo->modalityInfo->name ?? 'Modalidade não informada' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer p-1" style="border-top: 0;">
                        <a
                            href="{{ route('system.team.friendly-game.manage', [$team->id, $friendlyGame->id]) }}"
                            class="btn btn-primary w-100 "
                        >
                            Administrar Amistoso
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            @if($ownFriendlyGames->links())
                <div class="col-12 mt-3">
                    {{ $ownFriendlyGames->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
