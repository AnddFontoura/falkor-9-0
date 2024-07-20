@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-12 mt-3">
                    <a
                        href="{{ route('system.friendly-game.form_create') }}"
                        class='btn btn-success w-100'
                    >
                        Criar um amistoso
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ route('system.friendly-game.index') }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar amistosos
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teamName">Nome do time</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="teamName"
                                        name="teamName"
                                        placeholder="Nome do time"
                                        value="{{ Request::get('teamName') ?? '' }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teamCity">Estado do time</label>
                                    <select class="form-control select2bs4" id="teamState" name="stateId">
                                        <option value="0"> -- Selecione o Estado -- </option>
                                        @foreach($states as $state)
                                            @php
                                                Request::get('stateId') == $state->id ? $select = 'selected': $select = '';
                                            @endphp

                                            <option value="{{ $state->id }}" {{ $select }}>{{ $state->name }} ({{ $state->short }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teamCity">Cidade do time</label>
                                    <select class="form-control select2bs4" id="teamCity" name="cityId">
                                        <option value="0"> -- Selecione a Cidade -- </option>
                                        @foreach($cities as $city)
                                            @php
                                                Request::get('cityId') == $city->id ? $select = 'selected': $select = '';
                                            @endphp

                                            <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="teamGender">Gênero do Time</label>
                                    <select class="form-control" id="teamGender" name="teamGender">
                                        <option value="-1"> -- Selecione o Gênero -- </option>
                                        @foreach($teamGender as $key => $value)
                                            @php
                                                Request::get('teamGender') == $key ? $select = 'selected' : $select = '';
                                            @endphp

                                            <option value="{{ $key }}" {{ $select }}>{{ $value }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">
                                <div class="form-group">
                                    <label for="modalityId">Modalidade do time</label>
                                    <select class="form-control" id="modalityId" name="modalityId">
                                        <option value="-1"> -- Selecione a modalidade -- </option>
                                        @foreach($modalities as $modality)
                                            @php
                                                Request::get('modalityId') == $modality->id ? $select = 'selected' : $select = '';
                                            @endphp

                                            <option value="{{ $modality->id }}" {{ $select }}>{{ $modality->name }} </option>
                                        @endforeach
                                    </select>
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

        <div class="col-12">
            <div class="row">
                @if(count($friendlyGames) > 0)
                    @foreach($friendlyGames as $friendlyGame)
                        @php
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
                                                {{ $friendlyGame->matchStart->format('d/m/Y') }} -
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
                                        href="{{ route('system.friendly-game.show', $friendlyGame->id) }}"
                                        class="btn btn-primary w-100 "
                                    >
                                        Dados do Amistoso
                                    </a>
                                    <a
                                        href="{{ route('system.team.show', $friendlyGame->team_id) }}"
                                        class="btn btn-success mt-1 w-100"
                                        target="_blank"
                                    >
                                        Página do time
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($friendlyGames->links())
                        <div class="col-12 mt-3">
                            {{ $friendlyGames->withQueryString()->links() }}
                        </div>
                    @endif

            @else
                <div class='alert alert-danger'> Nenhum amistoso cadastrado </div>
            @endif
        </div>
    </div>
@endsection
