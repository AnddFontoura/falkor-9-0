@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.player.form_create') }}" class='btn btn-success'> Meu Perfil </a>
    </div>

    <div class="col-12 p-1">
        <form action="{{ route('system.player.index') }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar jogadores
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                                <div class="form-group">
                                    <label for="playerName">Nome do jogador</label>
                                    <input type="text" class="form-control" id="playerName" name="playerName" placeholder="Nome do time" value="{{ Request::get('teamName') ?? '' }}">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="teamCity">Estado do jogador</label>
                                <select class="form-control select2bs4" id="teamState" name="stateId">
                                    <option value="0"> -- Selecione o Estado -- </option>
                                    @foreach($states as $state)
                                    @php
                                    $select = '';
                                    @endphp

                                    @if(Request::get('stateId') == $state->id)
                                    @php
                                    $select = 'selected';
                                    @endphp
                                    @endif
                                    <option value="{{ $state->id }}" {{ $select }}>{{ $state->name }} ({{ $state->short }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-4">
                                <label for="teamCity">Cidade do jogador</label>
                                <select class="form-control select2bs4" id="teamCity" name="cityId">
                                    <option value="0"> -- Selecione a Cidade -- </option>
                                    @foreach($cities as $city)
                                    @php
                                    $select = '';
                                    @endphp

                                    @if(Request::get('cityId') == $city->id)
                                    @php
                                    $select = 'selected';
                                    @endphp
                                    @endif
                                    <option value="{{ $city->id }}" {{ $select }}>{{ $city->name }} ({{ $city->stateInfo->short }})</option>
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
            <div class="col-md-4">

                <div class="card card-widget widget-user">
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-6 border-right">
                                <div class="description-block">
                                    <h5 class="description-header"> {{ $match->home_team_name ?? 'null' }} </h5>
                                    <span class="description-text"> {{ $match->home_score ?? 'Sem Resultado' }}</span>
                                </div>

                            </div>

                            <div class="col-sm-6">
                                <div class="description-block">
                                    <h5 class="description-header">{{ $match->visitor_team_name ?? 'null' }}</h5>
                                    <span class="description-text">{{ $match->visitor_score ?? 'Sem Resultado' }}</span>
                                </div>

                            </div>

                            <div class="col-sm-12 border-top">
                                <div class="description-block">
                                    <h5 class="description-header">Partida em</h5>
                                    <span class="description-text">{{ $match->schedule->format('d/m/Y H:i') ?? '' }}</span>
                                    <div class="btn-group-vertical w-100 mt-1">
                                        <a href="{{ route('system.player.show', [ $player->id]) }}" class="btn btn-lg w-100 btn-primary"> Visualizar Perfil</a>
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
