@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
    </div>

    <div class="col-12 mt-3">

        @if($team->banner_path != '')
            @php
                $bannerPath = asset('storage/' . $team->banner_path);
            @endphp
        @endif

        @if($team->logo_path != '')
            @php
                $logoPath = asset('storage/' . $team->logo_path);
            @endphp
        @endif

        <div class="card card-widget widget-user">
            <div class="widget-user-header text-white" style="background: url('{{ $bannerPath }}') center center;">

            </div>
            <div class="widget-user-image">
                <img class="img-circle" src="{{ $logoPath }}" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-12 border-bottom less-height">
                        <div class="description-block">
                            <h5 class="description-header">{{ $team->name }}</h5>
                        </div>
                    </div>

                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">Cidade</h5>
                            <span class="description-text">{{ $team->cityInfo->name }}</span>
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

    <div class="col-6 p-1">
        <div class="btn-group">
            <a href="{{ route('system.team.form_update', $team->id) }}" class="btn btn-warning"> Editar time </a>
            <a href="{{ route('system.team-player.form_create', $team->id) }}" class="btn btn-success"> Incluir Jogador </a>
        </div>
    </div>

    <div class="col-6 p-1 text-right">
        <div class="btn-group">
            <a href="{{ route('system.team-player.index', $team->id) }}" class="btn btn-primary"> Lista de Jogadores </a>
        </div>
    </div>

    <div class="col-12 p-1">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 col-lg-6 col-sm-12 mt-1">
                        <h1> Jogadores </h1>
                        @if(count($players) == 0)
                            <div class="alert alert-secondary"> Nenhum jogador cadastrado nesse time </div>
                        @else
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>NÚMERO</th>
                                        <th>NOME</th>
                                        <th class="text-center">POSIÇÃO</th>
                                        <th class="text-center">OPÇÕES</th>
                                    </tr>
                                </thead>

                                <tbody>
                                @foreach($players as $player)
                                    <tr>
                                        <td>
                                            {{ $player->number }}
                                        </td>

                                        <td>
                                            <p class="text-bold"> {{ $player->name }} </p>
                                            <span class="text-muted m-0 p-0"> {{ $player->nickname }} </span>
                                        </td>
                                        <td class="text-center">{!! $player->gamePositionInfo->icon !!}</td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                <a href="{{ route('system.team-player.form_update', [$team->id, $player->id]) }}" class="btn btn-warning" alt="Editar" title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                                <a href="{{ route('system.team-player.show', [$team->id, $player->id]) }}" class="btn btn-primary" alt="Visualizar" title="Visualizar"> <i class="fas fa-eye"></i> </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
