@extends('layouts.adminlte')

@section('content_adminlte')

    @php
        $formUrl = isset($friendlyGame)
            ? route('system.friendly-game.update', $friendlyGame->id)
            : route('system.friendly-game.save');
        $ownedTeamId = $friendlyGame->team_id ?? old('ownedTeamId');
        $cityId = $friendlyGame->city_id ?? old('cityId');
        $matchDate = $friendlyGame->match_date ?? old('matchDate');
        $matchStart = $friendlyGame->start_at ?? old('matchStart');
        $matchDuration = $friendlyGame->duration ?? old('matchDuration');
        $matchDescription= $friendlyGame->description ?? old('matchDescription');
        $matchCost = $friendlyGame->price ?? old('matchCost');
        $teamFirstUniform = $friendlyGame->main_uniform_color ?? old('teamFirstUniform');
        $teamSecondUniform = $friendlyGame->secondary_uniform_color ?? old('teamSecondUniform');
        $action = isset($friendlyGame)
            ? 'Atualizar'
            : 'Criar';
        $thousandSeparator = __('general.numbers.thousand_separator');
        $decimalSeparator = __('general.numbers.decimal_separator');
        $moneyPattern = __('general.numbers.money_pattern');
    @endphp
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.friendly-game.index') }}"
                        class="btn btn-primary"
                    >
                        Listar amistosos
                    </a>
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
                                    <label for="ownedTeamId">Time do amistoso</label>
                                    <select class="form-control" name="ownedTeamId" id="ownedTeamId">
                                        @foreach($ownedTeams as $ownedTeam)
                                            @php
                                                $selectedTeam = $ownedTeam->id == $ownedTeamId ? 'selected' : '';
                                            @endphp
                                            <option value="{{ $ownedTeam->id }}" {{ $selectedTeam }}>
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
                                <label for="cityId">Cidade do amistoso</label>
                                <select class="form-control select2bs4" id="cityId" name="cityId">
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
                                <label for="matchDate">Data do Jogo</label>
                                <input
                                    type="date"
                                    class="form-control"
                                    id="matchDate"
                                    name="matchDate"
                                    value="{{ $matchDate }}"
                                >
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="matchStart">Início Previsto</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    id="matchStart"
                                    name="matchStart"
                                    value="{{ $matchStart }}"
                                >
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="matchTime">Duração da partida</label>
                                <input
                                    type="time"
                                    class="form-control"
                                    id="matchDuration"
                                    name="matchDuration"
                                    value="{{ $matchDuration }}"
                                >
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="matchCost">Custo para o time Desafiante</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    id="matchCost"
                                    name="matchCost"
                                    value="{{ number_format($matchCost, 2, $decimalSeparator, $thousandSeparator) }}"
                                >
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamFirstUniform">Cor 1º Uniforme</label>
                                <input
                                    type="color"
                                    class="form-control"
                                    id="teamFirstUniform"
                                    name="teamFirstUniform"
                                    value="{{ $teamFirstUniform }}"
                                >
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-3 col-sm-12 mt-3">
                            <div class="form-group">
                                <label for="teamSecondUniform">Cor 2º Uniforme</label>
                                <input
                                    type="color"
                                    class="form-control"
                                    id="teamSecondUniform"
                                    name="teamSecondUniform"
                                    value="{{ $teamSecondUniform }}"
                                >
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
                                <label for="matchDescription">Descrição</label>
                                <textarea
                                    class="form-control summernote"
                                    name="matchDescription"
                                    id="matchDescription"
                                >{!! $matchDescription !!}</textarea>
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <input type="submit" class="btn btn-success btn-lg" value="{{ $action }} amistoso">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
