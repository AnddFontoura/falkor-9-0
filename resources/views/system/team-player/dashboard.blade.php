@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12 p-1 mt-1">
            <div class="btn-group">

            </div>
        </div>

        <div class="col-12 p-1">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Futuras partidas</h3>
                </div>

                <div class="card-body">
                    @if(count($matches) == 0)
                        <div class="col-12 mt-3">
                            <div class='alert alert-danger'> Nenhuma partida para acontecer </div>
                        </div>
                    @else
                        @foreach($matches as $match)
                            @php
                                $homeTeamBanner = "";
                            @endphp
                            <div class="col-md-4">

                                <div class="card card-widget widget-user">
                                    <div class="card-footer">
                                        <div class="row">
                                            <div class="col-sm-6 border-right">
                                                <div class="description-block">
                                                    <h5 class="description-header"> {{ $match->home_team_name }} </h5>
                                                    <span class="description-text"> {{ $match->home_score ?? 'Sem Resultado' }}</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-6">
                                                <div class="description-block">
                                                    <h5 class="description-header">{{ $match->visitor_team_name }}</h5>
                                                    <span class="description-text">{{ $match->visitor_score ?? 'Sem Resultado' }}</span>
                                                </div>

                                            </div>

                                            <div class="col-sm-12 border-top">
                                                <div class="description-block">
                                                    <h5 class="description-header">Partida em</h5>
                                                    <span class="description-text">{{ $match->schedule->format('d/m/Y H:i') }}</span>
                                                    <div class="btn-group-vertical w-100 mt-1">
                                                        <a href="{{ route('system.matches.form_update', [$teamId, $match->id]) }}" class="btn btn-lg w-100 btn-warning"> Editar Jogo</a>
                                                        <a href="{{ route('system.match-players.form', [$teamId, $match->id]) }}" class="btn btn-lg w-100 btn-secondary"> Editar Jogadores</a>
                                                        <a href="{{ route('system.matches.show', [$teamId, $match->id]) }}" class="btn btn-lg w-100 btn-primary"> Visualizar Jogo</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page_js')
    <script>
        $('.btnInvitePlayer').on('click', function() {
            var playerId = $(this).data('playerid');

            Swal.fire({
                title: 'Indique o e-mail do jogador',
                input: 'email',
                inputLabel: 'Email do Jogador',
                inputPlaceholder: 'aaaa@aaaa.a.a',
                showCancelButton: true,
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "",
                        method: "POST",
                        data: {
                            teamPlayerId: playerId,
                            email: result.value
                        },
                        dataType: "json"
                    });
                    request.done(function() {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'Convidamos esse jogador',
                            type: 'success',
                            buttons: true,
                        })
                            .then((buttonClick) => {
                                if (buttonClick) {
                                    location.reload();
                                }
                            });
                    });
                    request.fail(function() {
                        Swal.fire(
                            'Erro',
                            'Algo deu errado ao convidar esse jogador, tente novamente mais tarde.',
                            'error'
                        )
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelado!',
                        'Nenhuma alteração realizada.',
                        'error'
                    )
                }
            });
        });

        $('.btnDelete').on('click', function() {
            var playerId = $(this).data('playerid');

            Swal.fire({
                title: 'Atenção!',
                text: 'Você está prestes a apagar um jogador. O jogador apagado não pode ser reativado. Ele continuará nas estatisticas e saldo como Jogador Deletado',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, apagar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "",
                        method: "DELETE",
                        data: {
                            id: playerId
                        },
                        dataType: "json"
                    });
                    request.done(function() {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'Apagamos esse jogador',
                            type: 'success',
                            buttons: true,
                        })
                            .then((buttonClick) => {
                                if (buttonClick) {
                                    location.reload();
                                }
                            });
                    });
                    request.fail(function() {
                        Swal.fire(
                            'Erro',
                            'Algo deu errado ao excluir esse jogador, tente novamente mais tarde.',
                            'error'
                        )
                    });
                } else if (result.dismiss === 'cancel') {
                    Swal.fire(
                        'Cancelado!',
                        'Nenhuma alteração realizada.',
                        'error'
                    )
                }
            });
        });
    </script>
@endsection
