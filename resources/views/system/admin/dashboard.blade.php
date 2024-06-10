@extends('layouts.adminlte')

@section('content_adminlte')
    <div class="row">
        <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $registeredUsers }}</h3>
                    <p>Usuários registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $registeredTeams }}</h3>
                    <p>Times registrados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $registeredProfiles }}</h3>
                    <p>Jogadores criados</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-md-3 col-lg-3 col-sm-12 mt-3">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $registeredMatches }}</h3>
                    <p>Partidas criadas</p>
                </div>
                <div class="icon">
                    <i class="ion ion-person-add"></i>
                </div>
                <a href="{{ route('admin.user.index') }}" class="small-box-footer">
                    More info
                    <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@endsection
