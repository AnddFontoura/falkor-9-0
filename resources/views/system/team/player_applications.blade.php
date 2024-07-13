@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.team-player.index', $team->id) }}"
                        class='btn btn-success w-100'
                    >
                        Listar jogador
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ route('system.team-player.index', $team->id) }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar jogadores
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="playerName">Nome do jogador</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="playerName"
                                        name="playerName"
                                        placeholder="Nome do jogador"
                                        value="{{ Request::get('playerName') ?? '' }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="playerNickName">Apelido do jogador</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="playerNickName"
                                        name="playerNickName"
                                        placeholder="Apelido do jogador"
                                        value="{{ Request::get('playerNickName') ?? '' }}"
                                    >
                                </div>
                            </div>

                            <div class="col-md-4">
                                <label for="gamePositionId">Posição do jogador</label>
                                <select class="form-control select2bs4" id="gamePositionId" name="gamePositionId">
                                    <option value="0"> -- Selecione a posição -- </option>
                                    @foreach($gamePositions as $gamePosition)
                                        @php
                                            $select = Request::get('gamePositionId') == $gamePosition->id
                                                ? 'selected'
                                                : '';
                                        @endphp
                                        <option
                                            value="{{ $gamePosition->id }}"
                                            {{ $select }}
                                        >
                                            {{ $gamePosition->name }} ({{ $gamePosition->short }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Filtrar jogadores">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Jogadores aplicados</h3>
                </div>

                <div class="card-body">
                    @if(count($teamApplications) == 0)
                        <div class="col-12 mt-3">
                            <div class='alert alert-danger'> Nenhum Jogador cadastrado </div>
                        </div>
                    @else
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="w-50">NOME</th>
                                <th class="w-10">POSIÇÃO</th>
                                <th> Cidade(Estado) </th>
                                <th class="text-right"> OPÇÕES </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($teamApplications as $player)
                                <tr>
                                    <td>
                                        {{ $player->playerInfo->name }}
                                        <p class="text-muted"> {{ $player->playerInfo->nickname }}</p>
                                    </td>

                                    <td class="text-center w-10">
                                        {!! $player->gamePositionInfo->icon !!}
                                    </td>

                                    <td>
                                        {{ $player->playerInfo->cityInfo->name }}
                                        ({{ $player->playerInfo->cityInfo->stateInfo->short }})
                                    </td>

                                    <td class="text-right">
                                        <div class="btn-group">
                                            <div
                                                class="btn btn-danger decidePlayerApplication"
                                                title="Decidir"
                                                data-playerapplicationid="{{ $player->id }}"
                                            >
                                                <i class="fas fa-question"></i>
                                            </div>
                                            <a
                                                href="{{ route('system.player.show', [ $player->player_id]) }}"
                                                class="btn btn-primary"
                                                title="Visualizar"
                                                target="_blank"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>

                @if($teamApplications->links())
                    <div class="card-footer clearfix">
                        {{ $teamApplications->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@section('page_js')
    <script>
        $('.decidePlayerApplication').on('click', function() {
            var playerApplicationId = $(this).data('playerapplicationid');

            Swal.fire({
                title: 'Você deseja aceitar esse jogador no time?',
                html: '<select id="applicationResult" class="swal2-select">' +
                    '<option value="0"> Não </option> ' +
                    '<option value="1"> Sim </option> '+
                    '</select>' +
                    '<label class="swal2-input-label"> Adicionar comentário (será exibido ao jogador) </label>' +
                    '<textarea id="rejectDescription" class="swal2-textarea"></textarea>',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById("applicationResult").value,
                        document.getElementById("rejectDescription").value
                    ];
                },
                showCancelButton: true,
                cancelButtonText: 'Avaliar mais tarde',
            }).then((result) => {
                if (result.value) {
                    console.log(result)
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ route('system.t-a.result', [$team->id]) }}",
                        method: "POST",
                        data: {
                            applicationResult: result.value[0],
                            rejectDescription: result.value[1],
                            applicationId: playerApplicationId
                        },
                        dataType: "json"
                    });
                    request.done(function(response) {
                        Swal.fire({
                            title: 'Pronto!',
                            text: response.message,
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
                        url: "{{ url('teams-has-players/delete') }}",
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
