@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12 mt-3">
            <a href="{{ route('system.team.form_create') }}" class='btn btn-success'> Cadastrar time </a>
        </div>
        @if(count($teams) > 0)
        @foreach($teams as $team)
        <div class="col-md-4 mt-3">
            <div class="card card-widget widget-user shadow">
                <div class="widget-user-header" style="background-image: url('{{ asset('storage/' . $team->banner_path) }}'); background-size: 100%; background-position: center;">
                    <h3 class="widget-user-username">{{ $team->name }}</h3>
                </div>
                <div class="widget-user-image">
                    <img class="elevation-2" src="{{ asset('storage/' . $team->logo_path) }}" alt="Team Logo">
                </div>
                <div class="card-footer">
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