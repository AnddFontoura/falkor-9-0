@extends('layouts.adminlte')

@section('content_adminlte')

    @php
        $formUrl = isset($friendlyGame) ? route('system.team.update', $team->id) : route('system.team.save');
        $ownedTeamId = $friendlyGame->name ?? old('teamName');
        $cityId = $friendlyGame->city_id ?? old('cityId');
        $matchDate = $friendlyGame->match_date ?? old('teamModality');
        $matchStart = $friendlyGame->start_at ?? old('xpto');
        $matchTime = $friendlyGame->duration ?? old('foundationDate');
        $matchDuration = $friendlyGame->description ?? old('teamDescription');
        $matchCost = $friendlyGame->price ?? old('xpto');
        $teamFirstUniform = $friendlyGame->main_uniform_color ?? old('xpto');
        $teamSecondUniform = $friendlyGame->secondary_uniform_color ?? old('xpto');
        $action = isset($friendlyGame) ? 'Atualizar' : 'Criar'
    @endphp
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 mt-3">
                    <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ $formUrl }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="callout callout-success">
                    <h1> {{ $action }} Amistoso </h1>

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

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <label for="teamDescription">Time do amistoso</label>
                                    <select class="form-control" name="teamDescription" id="teamDescription">
                                        @foreach($ownedTeams as $ownedTeam)
                                            <option value="{{ $ownedTeam->id }}">
                                                {{ $ownedTeam->name }}
                                                [{{$ownedTeam->modalityInfo->name ?? ''}}] -
                                                {{ $ownedTeam->cityInfo->name ?? ''}} / {{ $ownedTeam->cityInfo->stateInfo->short }}

                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamCity">Cidade do amistoso</label>
                                <select class="form-control select2bs4" id="teamCity" name="cityId">
                                    @foreach($cities as $city)
                                        @php
                                            $cityId == $city->id ? $select = 'selected' : $select = '';
                                        @endphp

                                        <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Data do Jogo</label>
                                <input type="date" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Início Previsto</label>
                                <input type="time" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Duração da partida</label>
                                <input type="time" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Custo para o time Desafiante</label>
                                <input type="text" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Cor 1º Uniforme</label>
                                <input type="color" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamBirth">Cor 2º Uniforme</label>
                                <input type="color" class="form-control" id="teamBirth" name="foundationDate" value="{{ $foundationDate }}">
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <div class="form-group">
                                <div class="alert alert-success">
                                    <p>
                                        Coloque o endereço do jogo ou proximidades. Se tiver link do google para o maps,
                                        melhor ainda!
                                    </p>

                                    <p>
                                        Deixe também seu telefone se sentir a vontade para entrarem em contato caso
                                        necessário e não esqueça de acompanhar aqui os times que se ofereçeram para
                                        o amistoso, você pode escolher o time que enfrentará, o time será notificado
                                        mas é sempre bom acompanhar via whatsapp.
                                    </p>

                                    <p>
                                        No futuro teremos uma série de melhorias nessa etapa, por enquanto está bem cru.
                                    </p>

                                </div>
                                <label for="teamDescription">Descrição</label>
                                <textarea class="form-control summernote" name="teamDescription" id="teamDescription">{!! $teamDescription !!}</textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} time">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
