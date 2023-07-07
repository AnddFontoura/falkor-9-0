@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.form_create') }}" class='btn btn-success'> Cadastrar time </a>
    </div>
    @if(count($teams) > 0)
    @foreach($teams as $team)
    @php
    $bannerPath = asset("storage/" . $team->banner_path);
    $logoPath = asset('storage/' . $team->logo_path);
    @endphp
    <div class="col-md-4 mt-3 d-flex align-items-stretch">
        <div class="card card-widget widget-user shadow bg-light color-palette">
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
</div>
@else
<div class="col-12 mt-3">
    <div class='alert alert-danger'> Nenhum Time cadastrado </div>
</div>
@endif
@endsection