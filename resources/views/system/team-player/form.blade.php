@extends('layouts.adminlte')

@section('content_adminlte')

@php
    $formUrl = isset($player) ? route('system.team-player.update', [$player->team_id, $player->id]) : route('system.team-player.save', [$teamId]);
    $playerName = $player->name ?? old('playerName');
    $playerGamePosition = $player->game_position_id ?? old('playerGamePosition');
    $playerNickName = $player->nickname ?? old('playerNickName');
    $playerUniformSize = $player->uniform_size ?? old('playerUniformSize');
    $playerNumber = $player->number ?? old('playerNumber');
    $playerHeight = $player->height ?? old('playerHeight');
    $playerWeight = $player->weight ?? old('playerWeight');
    $playerFootSize = $player->foot_size ?? old('playerFootSize');
    $playerGloveSize = $player->glove_size ?? old('playerGloveSize');
    $playerBirthdate = $player->birthdate ?? old('playerBirthdate');
    $action = isset($player) ? 'Atualizar' : 'Criar';
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.manage', $teamId) }}" class="btn btn-primary"> Administrar Time </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> {{ $action }} Jogador </h1>

                <div class="row">

                    @if ($errors->any())
                    <div class="col-12 alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerGamePosition">Posição do Jogador</label>
                            <select class="form-control select2bs4" id="playerGamePosition" name="playerGamePosition">
                                @foreach($gamePositions as $gamePosition)
                                    @php
                                        $select = '';
                                    @endphp

                                    @if($playerGamePosition == $gamePosition->id)
                                        @php
                                            $select = 'selected';
                                        @endphp
                                    @endif
                                <option value="{{ $gamePosition->id }}" {{ $select }}>{{ $gamePosition->name }} ({{ $gamePosition->short }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerUniformSize">Tamanho do Uniforme</label>
                            <select class="form-control select2bs4" id="playerUniformSize" name="playerUniformSize">
                                @foreach($uniformSizes as $uniformSize)
                                    @php
                                        $select = '';
                                    @endphp

                                    @if($playerUniformSize == $uniformSize)
                                        @php
                                            $select = 'selected';
                                        @endphp
                                    @endif
                                    <option value="{{ $uniformSize }}" {{ $select }}>{{ $uniformSize }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerBirthdate">Data de Nascimento</label>
                            <input type="date" class="form-control" id="playerBirthdate" name="playerBirthdate" value="{{ $playerBirthdate }}">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="playerName">Nome do Jogador</label>
                            <input type="text" class="form-control" id="playerName" name="playerName" placeholder="Nome do jogador" value="{{ $playerName }}">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="playerNickName">Apelido do Jogador</label>
                            <input type="text" class="form-control" id="playerName" name="playerNickName" placeholder="Apelido do jogador" value="{{ $playerNickName }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerNumber">Numero do Jogador</label>
                            <input type="number" class="form-control" id="playerNumber" name="playerNumber" placeholder="Numero do Uniforme" value="{{ $playerNumber }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerHeight">Altura do Jogador (cm)</label>
                            <input type="number" class="form-control" id="playerHeight" name="playerHeight" placeholder="Altura em Centimetros" value="{{ $playerHeight }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerWeight">Peso do Jogador (Kg)</label>
                            <input type="text" class="form-control" id="playerWeight" name="playerWeight" placeholder="Peso em KG" value="{{ $playerWeight }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerFootSize">Tamanho do Calçado</label>
                            <input type="text" class="form-control" id="playerFootSize" name="playerFootSize" placeholder="Tamanho do pé em número" value="{{ $playerFootSize }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerGloveSize">Tamanho da Luva</label>
                            <input type="text" class="form-control" id="playerGloveSize" name="playerGloveSize" placeholder="Tamanho da luva" value="{{ $playerGloveSize }}">
                        </div>
                    </div>

                    <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="playerPhoto">Foto do Jogador</label>
                            <input type="file" class="form-control" id="playerPhoto" name="playerPhoto">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} jogador">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
