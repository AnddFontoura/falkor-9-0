@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.form_create') }}" class='btn btn-success'> Cadastrar time </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.team.index') }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar times
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="teamName">Nome do time</label>
                                <input type="text" class="form-control" id="teamName" name="teamName" placeholder="Nome do time" value="{{ Request::get('teamName') ?? '' }}">
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
                                <label for="modality">Modalidade do time</label>
                                <select class="form-control" id="modality" name="modality">
                                    <option value="-1"> -- Selecione a modalidade -- </option>
                                    @foreach($modalities as $modality)
                                        @php
                                            Request::get('modality') == $modality->id ? $select = 'selected' : $select = '';
                                        @endphp

                                        <option value="{{ $modality->id }}" {{ $select }}>{{ $modality->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Filtrar times">
                </div>
            </div>
        </form>
    </div>
    @if(count($teams) > 0)
    @foreach($teams as $teamInfo)
    @php
        isset($teamInfo->logo_path) ?
            $logoPath = asset('storage/' . $teamInfo->logo_path)
            : $logoPath = asset('img/dragon.png');

        isset($teamInfo->banner_path) ?
            $bannerPath = asset('storage/' . $teamInfo->banner_path)
            : $bannerPath = asset('img/synthetic_grass.png');

    @endphp
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100 card-widget widget-user shadow bg-light color-palette">
            <div class="widget-user-header" style="background-image: url('{{ $bannerPath }}'); background-position: center; background-size: 150%">
                <div class="widget-user-username">
                    <h3>{{ $teamInfo->name }}</h3>
                </div>
            </div>
            <div class="widget-user-image">
                <img class="elevation-2" src="{{ $logoPath }}" alt="Team Logo">
            </div>
            <div class="card-body mt-3 bg-light color-palette">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Cidade</h5>
                            <span class="description-text">{{ $teamInfo->cityInfo->name }} </span>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Estado</h5>
                            <span class="description-text">{{ $teamInfo->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer text-center pt-3">
                <div class="btn-group">
                    <a href="{{ route('system.team.show', [$teamInfo->id]) }}" class="btn btn-primary"> Visualizar </a>
                    @if($teamInfo->user_id == Auth::id())
                    <a href="{{ route('system.team.manage', [$teamInfo->id]) }}" class="btn bg-purple color-palette"> Administrar </a>
                    @endif
                    @if($teamInfo->playerId)
                        <a href="{{ route('system.team-player.dashboard', [$teamInfo->id]) }}" class="btn btn-success"> Jogador </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endforeach

    @if($teams->links())
    <div class="col-12 mt-3">
        {{ $teams->withQueryString()->links() }}
    </div>
    @endif

</div>

@else
<div class="col-12 mt-3">
    <div class='alert alert-danger'> Nenhum Time cadastrado </div>
</div>
@endif
@endsection
