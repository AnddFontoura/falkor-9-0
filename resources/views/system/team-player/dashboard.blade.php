@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-lg-2 col-md-4 col-12 mt-3">
            <a
                class="btn btn-primary"
                href="{{ route('system.team-player.show', [$team->id, $teamPlayerInfo->id]) }}"
            >
                Meu perfil no time
            </a>
        </div>

        <div class="col-12 mt-3">
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
                                                        @if($match->confirmed)
                                                            <button
                                                                class="btn btn-danger btnChangeConfirmed"
                                                                data-confirmed="0"
                                                                data-id="{{ $match->id }}"
                                                            >
                                                                Cancelar Presença
                                                            </button>
                                                        @else
                                                            <button
                                                                class="btn btn-success btnChangeConfirmed"
                                                                data-confirmed="1"
                                                                data-id="{{ $match->id }}"
                                                            >
                                                                Confirmar Presença
                                                            </button>
                                                        @endif

                                                        <a
                                                            href="{{ route('system.team.matches', [0, $match->id]) }}"
                                                            class="btn w-100 btn-primary"
                                                        >
                                                            Visualizar Jogo
                                                        </a>
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
        $('.btnChangeConfirmed').on('click', function() {
            let matchId = $(this).data('id');
            let confirmed = $(this).data('confirmed');
            let swalText = '';

            if (confirmed)
                swalText = 'confirmar'
            else
                swalText = 'cancelar'

            Swal.fire({
                title: 'Atenção!',
                text: 'Você está prestes a ' + swalText + ' a presença.',
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ route('system.match-players.player_confirmation', [$team->id]) }}",
                        method: "POST",
                        data: {
                            matchId: matchId,
                            confirmed: confirmed
                        },
                        dataType: "json"
                    });
                    request.done(function() {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'Sua presença foi modificada',
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
                            'Algo deu errado ao ' + swalText + ' sua presença, tente novamente mais tarde.',
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
