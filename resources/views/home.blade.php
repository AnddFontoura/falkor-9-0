@extends('layouts.adminlte')

@section('content_adminlte')

<div class="container-fluid border">
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
            Seu plano atual é <strong>Bola de Ouro</strong> e expira em <strong>3 meses e 10 dias</strong>. Conheça nossos outros planos <a href="#">aqui</a>!
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times Participando</h2>
                    <div class="card-tools">
                        <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body d-flex">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header bg-secondary" data-toggle="collapse" data-target="#time-1" style="cursor:pointer;">
                                <h2 class="card-title">Flamengo</h2>
                            </div>
                            <div id="time-1" class="card-body border collapse text-center">
                                <figure class="w-50 mx-auto">
                                    <img class="img-thumbnail img-fluid" src="{{ asset('img/dragon.png') }}">
                                </figure>
                                <h4>Flamengo</h4>
                                <div>
                                    Posição: Atacante
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-info">
                    <h2 class="card-title">Times Administrando</h2>
                    <div class="card-tools">
                    <button data-card-widget="collapse" class="btn btn-tool btn-sm">
                    <i class="fas fa-times"></i>
                    </button>
                    </div>
                </div>
                <div class="card-body"></div>
            </div>
        </div>

    </div>

    <div class="row col-md-12">
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
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle text-center">
                    <thead>
                        <tr>
                        <th>Time</th>
                        <th>Adversário</th>
                        <th>Data</th>
                        <th>Local</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Flamengo</td>
                            <td>Botafogo</td>
                            <td>12/06/2024</td>
                            <td>Maracanã</td>
                        </tr>
                        <tr>
                            <td>Flamengo</td>
                            <td>Botafogo</td>
                            <td>12/06/2024</td>
                            <td>Maracanã</td>
                        </tr>
                    </tbody>
                </table>
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