@extends('layouts.external')

@section('content_external')
    <div class='row'>
        <div class="col-12">
            <form action="{{ route('external.teams') }}" method="GET">
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
                                    <label for="teamGender">Gênero do time</label>
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
                @endphp
                <div class="col-md-4 d-flex align-items-stretch mt-3">
                    <div class="card w-100 shadow bg-light color-palette">
                        <div class="card-body mt-3 bg-light color-palette">
<div class="row">
    <div class="col-md-6 col-lg-6 col-sm-12">
        <img class="w-100" src="{{ $logoPath }}" alt="Team Logo">
    </div>

    <div class="col-md-6 col-lg-6 col-sm-12">
        <h3>{{ $teamInfo->name }}</h3>
        <span class="text-muted">
            {{ $teamInfo->cityInfo->name }}
            ({{ $teamInfo->cityInfo->stateInfo->name }})
        </span>

    </div>
</div>
                         </div>

                        <div class="card-footer text-center pt-3">
                            <a href="{{ route('system.team.show', [$teamInfo->id]) }}" class="w-100 btn btn-primary"> Visualizar </a>
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
