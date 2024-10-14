@extends('layouts.adminlte')

@section('content_adminlte')
@php
    $playerName = $player->name ?? old('playerName');
    $playerNickname = $player->nickname ?? old('playerNickname');
    $playerBirthdate = $player->birthdate ?? old('playerBirthdate');
    $playerHeight = $player->height ?? old('playerHeight');
    $playerWeight = $player->weight ?? old('playerWeight');
    $playerFootSize = $player->foot_size ?? old('playerFootSize');
    $playerGloveSize = $player->glove_size ?? old('playerGloveSize');
    $playerStatus = $player->status ?? old('playerStatus');
    $playerGamePositions = $player->gamePositions ?? [];
    $playerModalities = $player->modalities ?? [];
    $playerYoutube = $player->social_profiles['youtube'] ?? '';
    $playerInstagram = $player->social_profiles['instagram'] ?? '';
    $playerX = $player->social_profiles['x'] ?? '';
    $playerFacebook = $player->social_profiles['facebook'] ?? '';
    $playerGDA = $player->social_profiles['gda'] ?? '';
    $playerKwai = $player->social_profiles['kwai'] ?? '';
    $playerTiktok = $player->social_profiles['tiktok'] ?? '';
@endphp
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
                            <label> Modalidades que joga </label>
                            <select
                                class="form-control select2 select-multiple"
                                multiple="multiple"
                                data-placeholder="Selecione uma ou mais opções"
                                name='playerModalities[]'
                            >
                                @foreach($modalities as $modality)
                                    @php
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

                        <div class="col-sm-12 col-lg-12 col-md-12 form-group">
                            <label> Posição que joga </label>
                            <select
                                class="form-control select2 select-multiple"
                                multiple="multiple"
                                data-placeholder="Selecione uma ou mais opções"
                                name='playerGamePositions[]'
                            >
                                @foreach($gamePositions as $position)
                                    @php
                                        in_array($position->id, $playerGamePositions)
                                            ? $selectedPositions = 'selected'
                                            : $selectedPositions = '';
                                    @endphp
                                    <option
                                        value="{{ $position->id }}"
                                        {{ $selectedPositions }}
                                    >
                                        {{ $position->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Nome de Jogador </label>
                            <input required class="form-control" type='text' value="{{ $playerName }}" name='playerName' id='playerName'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Apelido de Jogador </label>
                            <input class="form-control" type='text' value="{{ $playerNickname }}" name='playerNickname' id='playerNickname'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Data de Nascimento </label>
                            <input required class="form-control" type='date' value="{{ $playerBirthdate }}" name='playerBirthdate' id='playerBirthdate'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Cidade em que mora </label>
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
                            <label> Cidade de Nascimento </label>
                            <select class="form-control select2bs4" id="playerBirthCity" name="playerBirthCity">
                                @foreach($cities as $city)
                                    @php
                                        $cityId = $player->birth_city_id ?? null;

                                        $cityId == $city->id ? $select = 'selected' : $select = '';
                                    @endphp

                                    <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Altura </label>
                            <input required class="form-control" type='number' min='60' max='220' value="{{ $playerHeight }}" name='playerHeight' id='playerHeight'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Peso </label>
                            <input class="form-control" type='number' min='20' max='220' value="{{ $playerWeight }}" name='playerWeight' id='playerWeight'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Tamanho da chuteira </label>
                            <input required class="form-control" type='number' min='10' max='50' value="{{ $playerFootSize }}" name='playerFootSize' id='playerFootSize'></input>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Tamanho da luva </label>
                            <input class="form-control" type='number' min='5' max='12' value="{{ $playerGloveSize }}" name='playerGloveSize' id='playerGloveSize'></input>
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

                        <div class="col-sm-12 col-lg-4 col-md-4 form-group">
                            <label> Gênero </label>
                            <select class="form-control select2bs4" id="playerGender" name="playerGender">
                                @foreach($genderArray as $key => $result)
                                    @php
                                        $genderControl = $player->gender ?? null;
                                        $genderControl == $key ? $select = 'selected' : $select = '';
                                    @endphp

                                    <option value="{{ $key }}" {{ $select }}>{{ $result }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 form-group">
                            <label for="playerPhoto">Foto do Jogador</label>
                            <input type="file" class="form-control" id="playerPhoto" name="playerPhoto">
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerYoutube">Youtube</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://youtube.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerYoutube"
                                    id="playerYoutube"
                                    value="{{ $playerYoutube }}"
                                >
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerFacebook">Facebook</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://facebook.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerFacebook"
                                    id="playerFacebook"
                                    value="{{ $playerFacebook }}"
                                >
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerX">X (Antigo Twitter)</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://x.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerX"
                                    id="playerX"
                                    value="{{ $playerX }}"
                                >
                            </div>
                         </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerInstagram">Instagram</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://www.instagram.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerInstagram"
                                    id="playerInstagram"
                                    value="{{ $playerInstagram }}"
                                >
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerTiktok">Tiktok</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://tiktok.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerTiktok"
                                    id="playerTiktok"
                                    value="{{ $playerTiktok }}"
                                >
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerKwai">Kwai</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://www.kwai.com/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerKwai"
                                    id="playerKwai"
                                    value="{{ $playerKwai }}"
                                >
                            </div>
                        </div>

                        <div class="col-sm-12 col-lg-4 col-md-6 form-group">
                            <label for="playerGda">Goleiro de Aluguel</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">https://goleiro.app/</span>
                                </div>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Nome no app"
                                    name="playerGda"
                                    id="playerGda"
                                    value="{{ $playerGDA }}"
                                >
                            </div>
                        </div>

                        <div class="col-12 form-group">
                            <label>Exibir seus dados na lista de jogadores?:</label>
                            <select class="form-control" name="playerStatus">
                                <option value='1'>Sim</option>
                                <option value='0'>Não</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class='card-footer'>
                    <button class="btn btn-success" type='submit'>Salvar Informações de jogador</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('page_js')
<script>

</script>
@endsection
