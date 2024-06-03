@extends('layouts.adminlte')

@section('content_adminlte')

<div class="row">
    @if(count($playerInvitations) > 0)
    <div class="col-md-4 col-lg-3 col-sm-12 mt-3 p-1">
        <a href="{{ route('system.player-invitation.index') }}">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Você tem um convite ativo!</h5>
                Algum time te convidou para fazer parte do elenco, clique aqui para avaliar o convite.
            </div>
        </a>
    </div>
    @endif
</div>

<div class="container-fluid">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard v2</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title">Conheça nossos planos!</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-times"></i>
                </button>
            </div>
        </div>

        <div class="card-body">
            @if($planInfo != null)
                Seu plano atual é <strong>{{ $planInfo->name }}</strong> e expira <strong>{{ $planFinishDate }}</strong>. Conheça nossos outros planos <a href="{{ route('system.plans.form')}}">aqui</a>!
            @else
                Você não tem um plano ativo :( ... Conheça nossos planos <a href="{{ route('system.plans.form') }}">aqui</a> {{$planFinishDate}}!
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times Participando</h2>
                    <div class="card-tools">
                        <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row">
                        @foreach($teamsPlayer as $teamPlayer)
                            <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" data-toggle="collapse" data-target="#team-player-{{ $teamPlayer->id }}" style="cursor:pointer;">
                                    <figure class="w-25 mx-auto">
                                        <img class="img-thumbnail img-fluid" src="{{ asset('img/dragon.png') }}">
                                    </figure>
                                </div>
                                <div id="team-player-{{ $teamPlayer->id }}" class="card-body border collapse text-center bg-light">
                                    <h4 class="text-info">{{ $teamPlayer->teamInfo->name }}</h4>
                                    <div>
                                        <span class="text-bold">Posição</span>: {{ $teamPlayer->gamePositionInfo->name }}
                                    </div>
                                    <div>
                                        <span class="text-bold">Número da camisa</span>: {{ $teamPlayer->number }}
                                    </div>
                                    <div>
                                        <span class="text-bold">Ativo</span>:
                                            @if($teamPlayer->active)
                                                <span class="text-success">Sim</span>
                                            @else
                                                <span class="text-danger">Não</span>
                                            @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times Administrando</h2>
                    <div class="card-tools">
                    <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                    <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row">
                        @foreach($ownedTeams as $teamOwned)
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" data-toggle="collapse" data-target="#owned-team-{{ $teamOwned->id }}" style="cursor:pointer;">
                                    <figure class="w-25 mx-auto">
                                        <img class="img-thumbnail img-fluid" src="{{ asset('img/dragon.png') }}">
                                    </figure>
                                </div>
                                <div id="owned-team-{{ $teamOwned->id }}" class="card-body border collapse text-center bg-light">
                                    <h4 class="text-info">{{ $teamOwned->name }}</h4>
                                    <div>
                                        <span class="text-bold">Posição</span>: Dono
                                    </div>
                                    <div>
                                        <span class="text-bold">Jogador</span>: <span class="text-success">Sim</span>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header border-0 bg-success">
                <h2 class="card-title">Próximas partidas</h2>
                <div class="card-tools">
                    <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                    <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="d-flex flex-column flex-md-row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header" data-toggle="collapse" data-target="#time-1" style="cursor:pointer;">
                                    <div class="d-flex">
                                        <div class="d-flex align-items-center flex-column">
                                            <figure class="w-25 mx-auto">
                                                <img class="img-thumbnail img-fluid" src="{{ asset('img/dragon.png') }}">
                                            </figure>

                                            <div class="text-info text-bold">
                                                Flamengo
                                            </div>
                                        </div>

                                        <div class="h1">x</div>

                                        <div class="d-flex align-items-center flex-column">
                                            <figure class="w-25 mx-auto">
                                                <img class="img-thumbnail img-fluid" src="{{ asset('img/dragon.png') }}">
                                            </figure>

                                            <div class="text-danger text-bold">
                                                Vasco
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="time-1" class="card-body border collapse text-center bg-light">
                                    <h4>10/06/2024 - 20:00</h4>
                                    <div>
                                        <span class="text-bold">Endereço</span>: 191 Runolfsdottir Islands Torreyhaven, CA 68285
                                    </div>
                                    <div class="text-muted text-bold">
                                        Visitante
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    
</div>

{{--<div class="row">

    @if(count($playerInvitations) > 0)
    <div class="col-md-4 col-lg-3 col-sm-12 mt-3 p-1">
        <a href="{{ route('system.player-invitation.index') }}">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Você tem um convite ativo!</h5>
                Algum time te convidou para fazer parte do elenco, clique aqui para avaliar o convite.
            </div>
        </a>
    </div>
    @endif
</div>

<div class="row">
        <div class="col-12 d-flex flex-column mt-2">
                <div class="col-6 d-block">
                    <h2 class="m-0 p-0">Dashboard</h2>
                </div>
                <div class="col-6 d-flex">
                    <div class="col-4 info-box bg-warning">
                        <span class="info-box-icon"><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                        <div class="info-box-content">
                            <span class="info-box-text">Plano</span>
                            <span class="info-box-number">Dente de Leite</span>
                        </div>
                    </div>
                </div>
        </div>
</div>

<div class="row">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Latest Orders</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Item</th>
                                <th>Status</th>
                                <th>Popularity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><a href="pages/examples/invoice.html">OR9842</a></td>
                                <td>Call of Duty IV</td>
                                <td><span class="badge badge-success">Shipped</span></td>
                                <td>
                                    <div class="sparkbar" data-color="#00a65a" data-height="20">90,80,90,-70,61,-83,63</div>
                                </td>
                            </tr>    
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>

</div>

</div>

</div> --}}

@endsection