@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.player.index') }}" class="btn btn-primary"> Listar Jogadores </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.player.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class='card'>
                <div class="card-header text-center">
                    <h1> Meu perfil </h1>
                </div>
                <div class='card-body'>
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

                        <div class="col-sm-12 col-lg-12 col-md-12 form-group">
                            <label> Posição que joga </label>
                            <select class="form-control select2" multiple="multiple" data-placeholder="Selecione uma ou mais opções" name='playerGamePositions' id="select-multiple" '>
                                @foreach($gamePositions as $position)
                                    <option value="{{ $position->id }}">{{ $position->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Nome de Jogador </label>
                            <input required class="form-control" type='text' value="{{ $player->name ?? old('playerName') }}" name='playerName' id='playerName'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Apelido de Jogador </label>
                            <input class="form-control" type='text' value="{{ $player->nickname ?? old('playerNickname') }}" name='playerNickname' id='playerNickname'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Data de Nascimento </label>
                            <input required class="form-control" type='date' value="{{ $player->birthdate ?? old('playerBirthdate') }}" name='playerBirthdate' id='playerBirthdate'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Cidade do Jogador </label>
                            <select class="form-control select2bs4" id="playerCity" name="playerCity">
                                @foreach($cities as $city)
                                @php
                                $cityId = $player->city_id ?? null;

                                $cityId == $city->id ? $select = 'selected' : $select = '';
                                @endphp

                                <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Altura </label>
                            <input required class="form-control" type='number' min='60' max='220' value="{{ $player->height ?? old('playerHeight') }}" name='playerHeight' id='playerHeight'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Peso </label>
                            <input class="form-control" type='number' min='20' max='220' value="{{ $player->weight ?? old('playerWeight') }}" name='playerWeight' id='playerWeight'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Tamanho da chuteira </label>
                            <input required class="form-control" type='number' min='10' max='50' value="{{ $player->foot_size ?? old('playerFootSize') }}" name='playerFootSize' id='playerFootSize'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Tamanho da luva </label>
                            <input class="form-control" type='number' min='5' max='12' value="{{ $player->glove_size ?? old('playerGloveSize') }}" name='playerGloveSize' id='playerGloveSize'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Tamanho do uniforme </label>
                            <select class="form-control select2bs4" id="playerUniformSize" name="playerUniformSize">
                                @foreach($uniformSizes as $uniformSize)
                                @php
                                $uniformSizeControl = $player->uniform_size ?? null;
                                $uniformSizeControl == $uniformSize ? $select = 'selected' : $select = '';
                                @endphp

                                <option value="{{ $uniformSize }}" {{ $select }}>{{ $uniformSize }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12 form-group">
                            <label for="playerPhoto">Foto do Jogador</label>
                            <input type="file" class="form-control" id="playerPhoto" name="playerPhoto">
                        </div>

                        <div class="col-12 form-group">
                            <label>Exibir seus dados na lista de jogadores?:</label>
                            <select class="form-control" name="playerStatus">
                                <option value='1'>Sim</span>
                                <option value='0'>Não</span>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='card-footer'>
                    <button class="btn btn-success" type='submit'>Salvar Informações de jogador</button>
                </div>
            </div>
    </div>
    </form>
</div>
@endsection

@section('page_js')
<script>

</script>
@endsection