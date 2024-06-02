@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.team.form_create') }}" class='btn btn-success'> Cadastrar time </a>
    </div>

    <div class="col-12 p-1">
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
                            <label for="teamCity">Estado do time</label>
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
                            <label for="teamCity">Cidade do time</label>
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

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Filtrar times">
                </div>
            </div>
        </form>
    </div>
    @if(count($teams) > 0)
    @foreach($teams as $team)
    @php
        isset($team->logo_path) ?
            $logoPath = asset('storage/' . $team->logo_path)
            : $logoPath = asset('img/dragon.png');

        isset($team->banner_path) ?
            $bannerPath = asset('storage/' . $team->banner_path)
            : $bannerPath = asset('img/synthetic_grass.png');

    @endphp
    <div class="col-md-4 d-flex align-items-stretch">
        <div class="card w-100 card-widget widget-user shadow bg-light color-palette">
            <div class="widget-user-header" style="background-image: url('{{ $bannerPath }}'); ">
                <div class="widget-user-username">
                    <h3>{{ $team->name }}</h3>
                </div>
            </div>
            <div class="widget-user-image">
                <img class="elevation-2" src="{{ $logoPath }}" alt="Team Logo">
            </div>
            <div class="card-footer bg-light color-palette">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Cidade</h5>
                            <span class="description-text">{{ $team->cityInfo->name }} </span>
                        </div>

                    </div>
                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">Estado</h5>
                            <span class="description-text">{{ $team->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="description-block border-top less-height">
                            <div class="btn-group mt-3">
                                <a href="{{ route('system.team.show', [$team->id]) }}" class="btn btn-primary"> Visualizar </a>
                                @if($team->user_id == Auth::id())
                                <a href="{{ route('system.team.manage', [$team->id]) }}" class="btn bg-purple color-palette"> Administrar </a>
                                @endif
                            </div>
                        </div>
                    </div>
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
