@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 p-1 mt-1">
        <div class="btn-group">
            <a href="{{ route('system.team-player.form_create', $teamId) }}" class='btn btn-success'> Cadastrar jogador </a>
            <a href="{{ route('system.team.manage', $teamId) }}" class="btn bg-purple color-palette"> Administrar Time </a>
        </div>
    </div>

    <div class="col-12 p-1">
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
                                <input type="number" class="form-control" id="playerNumber" name="playerNumber" placeholder="Numero do jogador" value="{{ Request::get('playerNumber') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="playerName">Nome do jogador</label>
                                <input type="text" class="form-control" id="playerName" name="playerName" placeholder="Nome do jogador" value="{{ Request::get('playerName') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="playerNickName">Apelido do jogador</label>
                                <input type="text" class="form-control" id="playerNickName" name="playerNickName" placeholder="Apélido do jogador" value="{{ Request::get('playerNickName') ?? '' }}">
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="gamePositionId">Posição do jogador</label>
                            <select class="form-control select2bs4" id="gamePositionId" name="gamePositionId">
                                <option value="0"> -- Selecione a posição -- </option>
                                @foreach($gamePositions as $gamePosition)
                                    @php
                                    $select = '';
                                    @endphp

                                    @if(Request::get('gamePositionId') == $gamePosition->id)
                                        @php
                                            $select = 'selected';
                                        @endphp
                                    @endif
                                    <option value="{{ $gamePosition->id }}" {{ $select }}>{{ $gamePosition->name }} ({{ $gamePosition->short }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label for="playerWithUser">Jogadores Vinculados</label>
                            <input type="checkbox" value="1" class="form-control" id="playerWithUser" name="playerWithUser">
                        </div>

                        <div class="col-md-4">
                            <label for="withDeleted">Jogadores deletados</label>
                            <input type="checkbox" value="1" class="form-control" id="withDeleted" name="withDeleted">
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <input type="submit" class="btn btn-primary" value="Filtrar jogadores">
                </div>
            </div>
        </form>
    </div>

    <div class="col-12 p-1">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
            </div>

            <div class="card-body">
                @if(count($players) ==  0)
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
                                            <a href="" class="btn btn-danger" title="Vincular Usuario"> <i class="fas fa-user-plus"></i>  </a>
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
