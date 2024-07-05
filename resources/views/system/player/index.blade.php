@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-lg-2 col-md-4 col-sm-12 p-1 mt-3">
        <a
            href="{{ route('system.player.form_create') }}"
            class='btn btn-success'
        >
            Meu Perfil
        </a>
    </div>

    <div class="col-12 p-1">
        <form action="{{ route('system.player.index') }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar jogadores
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 col-sm-12 col-lg-4">
                            <div class="form-group">
                                <label for="playerName">Nome do jogador</label>
                                <input type="text" minlength="5" maxlength="254" class="form-control" name="playerName" id="name" placeholder="Nome do jogador" value="{{ Request::get('playerName') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-lg-4">
                            <div class="form-group">
                                <label for="teamCity">Estado do jogador</label>
                                <select class="form-control select2bs4" id="teamState" name="stateId">
                                    <option value="0"> -- Selecione o Estado -- </option>
                                    @foreach($states as $state)
                                        @php
                                            Request::get('stateId') == $state->id ? $select = 'selected' : $select = '';
                                        @endphp

                                        <option value="{{ $state->id }}" {{ $select }}>{{ $state->name }} ({{ $state->short }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-lg-4">
                            <div class="form-group">
                                <label for="teamCity">Cidade do jogador</label>
                                <select class="form-control select2bs4" id="teamCity" name="cityId">
                                    <option value="0"> -- Selecione a Cidade -- </option>
                                    @foreach($cities as $city)
                                        @php
                                            Request::get('cityId') == $city->id ? $select = 'selected' : $select = '';
                                        @endphp

                                        <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-4 col-sm-12 col-lg-4">
                            <div class="form-group">
                                <label for="playerGender">Cidade do jogador</label>
                                <select class="form-control" id="playerGender" name="playerGender">
                                    <option value="0"> -- Selecione o Gênero -- </option>
                                    @foreach($genderArray as $key => $value)
                                        @php
                                            Request::get('playerGender') == $key ? $select = 'selected' : $select = '';
                                        @endphp

                                        <option value="{{ $key }}" {{ $select }}>{{ $value }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <label> Modalidades que joga </label>
                                <select
                                    class="form-control select2 select-multiple"
                                    multiple="multiple"
                                    data-placeholder="Selecione uma ou mais opções"
                                    name='playerModalities[]'
                                >
                                    @foreach($modalities as $modality)
                                        @php
                                            $playerModalities = Request::get('playerModalities') ?? [];
                                            in_array($modality->id, $playerModalities) ?
                                                $selectedModalities = 'selected'
                                                : $selectedModalities = '';
                                        @endphp
                                        <option
                                            value="{{ $modality->id }}"
                                            {{ $selectedModalities }}
                                        >
                                            {{ $modality->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-12 col-md-12">
                            <div class="form-group">
                                <label> Posição que joga </label>
                                <select
                                    class="form-control select2 select-multiple"
                                    multiple="multiple"
                                    data-placeholder="Selecione uma ou mais opções"
                                    name='playerGamePositions[]'
                                >
                                    @foreach($gamePositions as $position)
                                        @php
                                            $playerGamePositions = Request::get('playerGamePositions') ?? [];
                                            in_array($position->id, $playerGamePositions) ?
                                                $selectedPositions = 'selected'
                                                : $selectedPositions = '';
                                        @endphp
                                        <option value="{{ $position->id }}" {{ $selectedPositions }}>{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Filtrar jogadores">
                </div>
            </div>
        </form>
    </div>
    @if(count($players) == 0)
    <div class="col-12 mt-3">
        <div class='alert alert-danger'> Nenhum jogador cadastrado </div>
    </div>
    @else
    @foreach($players as $player)
    @php
        isset($player->photo) ?
            $photoPath = asset('storage/' . $player->photo)
            : $photoPath = asset('img/dragon.png');
    @endphp
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100 card-widget widget-user shadow bg-light color-palette">
            <div class="widget-user-header bg-info">
                <div class="widget-user-username">
                    <h3>{{ $player->name }}</h3>
                </div>
            </div>
            <div class="widget-user-image">
                <img class="elevation-2" src="{{ $photoPath }}" alt="Player Logo">
            </div>
            <div class="card-footer bg-light color-palette">
                <div class="row">
                    <div class="col-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Cidade</h5>
                            <span class="description-text">{{ $player->cityInfo->name }} </span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="description-block">
                            <h5 class="description-header">Estado</h5>
                            <span class="description-text">{{ $player->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="description-block border-top">
                            <div class='mt-3'>
                                @if(isset($player->gamePositions))
                                @foreach($player->gamePositions as $gamePosition)
                                {!! $gamePosition->icon !!}
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="description-block border-top">
                            <div class="btn-group mt-3">
                                <a href="{{ route('system.player.show', [$player->id]) }}" class="btn btn-primary"> Visualizar </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @endforeach

    @if($players->links())
    <div class="col-12 mt-3">
        {{ $players->withQueryString()->links() }}
    </div>
    @endif
    @endif
</div>
@endsection
