@extends('layouts.external')

@section('content_external')
    <div class='row mt-3'>
        <div class="col-12">
            <form action="{{ route('external.players') }}" method="GET">
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
                                    <label for="playerGender">Gênero do jogador</label>
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
                                    <label> Posição que joga </label>
                                    <select class="form-control select2" multiple="multiple" data-placeholder="Selecione uma ou mais opções" name='playerGamePositions[]' id="select-multiple" '>
                                        @foreach($gamePositions as $position)
                                            @php
                                                $playerGamePositions = Request::get('playerGamePositions') ?? [];
                                                in_array($position->id, $playerGamePositions) ? $selectedPositions = 'selected' : $selectedPositions = '';
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
                <div class="col-md-4 d-flex align-items-stretch mt-3">
                    <div class="card w-100 shadow bg-light color-palette">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 col-lg-6">
                                    <img class="w-100" src="{{ $photoPath }}" alt="Foto do jogador">
                                </div>

                                <div class="col-6">
                                    <h3>{{ $player->name }}</h3>
                                    <span class="text-muted">
                                        {{ $player->cityInfo->name }}
                                        ({{ $player->cityInfo->stateInfo->short }})
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-light color-palette">
                            <a href="{{ route('system.player.show', [$player->id]) }}" class="btn btn-primary w-100"> Visualizar </a>
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
