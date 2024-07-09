@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team-player.form_create', $teamId) }}"
                    class='btn btn-success w-100'
                >
                    Cadastrar jogador
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.search-players', $teamId) }}"
                    class='btn btn-primary w-100'
                >
                    Procurar jogadores
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.players-applications', $teamId) }}"
                    class='btn btn-secondary w-100'
                >
                    Contratações
                </a>
            </div>

            <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                <a
                    href="{{ route('system.team.manage', $teamId) }}"
                    class="btn bg-purple color-palette w-100"
                >
                    Administrar Time
                </a>
            </div>
        </div>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.team-player.index', $teamId) }}" method="GET">
            <div class="card">
                <div class="card-header">
                    Filtrar jogadores
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="playerNumber">Numero do jogador</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    id="playerNumber"
                                    name="playerNumber"
                                    placeholder="Numero do jogador"
                                    value="{{ Request::get('playerNumber') ?? '' }}"
                                >
                            </div>
                        </div>

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

                        <div class="col-md-4">
                            <label for="playerWithUser">Jogadores Vinculados</label>
                            <input
                                type="checkbox"
                                value="1"
                                class="form-control"
                                id="playerWithUser"
                                name="playerWithUser"
                            >
                        </div>

                        <div class="col-md-4">
                            <label for="withDeleted">Jogadores deletados</label>
                            <input
                                type="checkbox"
                                value="1"
                                class="form-control"
                                id="withDeleted"
                                name="withDeleted"
                            >
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
                <h3 class="card-title">Jogadores do time</h3>
            </div>

            <div class="card-body">
                @if(count($players) == 0)
                <div class="col-12 mt-3">
                    <div class='alert alert-danger'> Nenhum Jogador cadastrado </div>
                </div>
                @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>NOME</th>
                            <th style="width: 40px">POSIÇÃO</th>
                            <th style="width: 40px">VINCULADO</th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($players as $player)
                        <tr>
                            <td>
                                {{ $player->number }}
                            </td>

                            <td>
                                {{ $player->name }}
                                <p class="text-muted"> {{ $player->nickname }}</p>
                            </td>

                            <td class="text-center">
                                {!! $player->gamePositionInfo->icon !!}
                            </td>

                            <td class="text-center">
                                @if($player->user_id)
                                <button class="btn btn-success" title="Usuario Vinculado"> <i class="fas fa-user"></i> </button>
                                @else
                                <button href="" class="btn btn-danger btnInvitePlayer" data-playerid="{{ $player->id }}" title="Vincular Usuario"> <i class="fas fa-user-plus"></i> </button>
                                @endif
                            </td>

                            <td class="text-right">
                                <div class="btn-group">
                                    <a href="{{ route('system.team-player.form_update', [$teamId, $player->id]) }}" class="btn btn-warning" title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                    <a href="{{ route('system.team-player.show', [$teamId, $player->id]) }}" class="btn btn-primary" title="Visualizar"> <i class="fas fa-eye"></i> </a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif

            </div>

            @if($players->links())
            <div class="card-footer clearfix">
                {{ $players->withQueryString()->links() }}
            </div>
            @endif
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
                    url: "{{ route('system.player-invitation.email-invitation', [$teamId]) }}",
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
