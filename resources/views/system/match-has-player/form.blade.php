@extends('layouts.adminlte')

@section('content_adminlte')

@php
    $amountCollected = 0;
@endphp
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.matches.index', [$team->id]) }}" class="btn btn-primary"> Listar Partidas </a>
        <a href="{{ route('system.team.manage', [$team->id]) }}" class="btn btn-primary"> Administar time </a>
    </div>

    <div class="col-12 mt-3">
        <div class="callout callout-success">
            <h1> Jogadores </h1>        
        </div>

        @if(count($teamPlayers) == 0)
            <div class='alert alert-danger'>
                Nenhum jogador registrado no seu time. Cadastre jogadores para editar a lista
            </div>
        @else
            @foreach($teamPlayers as $player)
                @php
                    $amountCollected += $player->matchHasPlayerInfo->price_payed ?? 0;
                    $shirtNumber = $player->matchHasPlayerInfo->number ?? $player->number;
                    $gamePosition = $player->matchHasPlayerInfo->game_position_id ?? $player->game_position_id;
                    $originalPosition = $player->gamePositionInfo->name ?? 'Não Preenchido';
                    $invited = $player->matchHasPlayerInfo->invited ?? false;
                    $confirmed = $player->matchHasPlayerInfo->confirmed ?? false;
                    $showedUp = $player->matchHasPlayerInfo->confirmed ?? false;
                    $showedUpCheck = $showedUp ? 'checked' : '';
                    $reasonForAbsence = $player->matchHasPlayerInfo->reason_for_absence ?? '';
                @endphp
                <div class='card player_{{ $player->id }}'>
                    <div class="card-header text-center">
                        <h1> {{ $player->name}} </h1>
                    </div>
                    <div class='card-body'>
                        <div class="row">
                            <div class="col-sm-12 col-lg-3 col-md-4 form-group">
                                <span> Número na camisa <b> (Org: {{ $player->number }}) </b> </span>
                                <input class="form-control" type='number' value="{{ $shirtNumber }}" name='playerNumber' id='playerNumber_{{ $player->id }}'></input>
                            </div>
                            
                            <div class="col-sm-12 col-lg-3 col-md-4 form-group">
                                <span> Posição em Campo <b> (Org: {{ $originalPosition }}) </b> </span>
                                <select class="form-control" name='gamePositionId' id='gamePositionId_{{ $player->id }}'>
                                    @foreach($gamePositions as $position)
                                        <option value="{{ $position->id }}">{{ $position->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-sm-12 col-lg-3 col-md-4 form-group">
                                <span> Convidado? (Email Enviado) </span>
                                <p> @if($invited) Sim @else Não @endif </p>
                            </div>
                            
                            <div class="col-sm-12 col-lg-3 col-md-4 form-group">
                                <span> Confirmado? (Respondeu email) </span>
                                <p> @if($confirmed) Sim @else Não @endif </p>
                            </div>
                            
                            <div class="col-sm-12 col-lg-3 col-md-4 form-group">
                                <span> Apareceu? (Estava em campo) </span>
                                <input type='checkbox' class='form-control' value='1' {{ $showedUpCheck }} name='showedUp_{{ $player->id }}' id='showedUp_{{ $player->id }}'></input>
                            </div>

                            
                            <div class="col-sm-12 col-lg-9 col-md-4 form-group">
                                <span> Motivo da falta (se faltou) </span>
                                <textarea type='checkbox' class='form-control' id="noShowReason_{{ $player->id }}">{{ $reasonForAbsence }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class='card-footer'>
                        <button class="btn btn-success savePlayerMatchInfo" data-playerid="{{ $player->id }}" data-matchid="{{ $match->id }}" value='Salvar Informações do jogador'>Salvar Informações do jogador</button>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection

@section('page_js')
    <script>
    $('.savePlayerMatchInfo').on('click', function() {
        let matchId = $(this).data('matchid');
        let playerId = $(this).data('playerid');
        let information = {};

        information.playerNumber = $('#playerNumber_' + playerId).val();
        information.playerPosition = $('select[id=gamePositionId_' + playerId + '] option').filter(':selected').val();
        information.showedUp = Boolean($('#showedUp_' + playerId).is(":checked"));
        information.noShowReasion = $('#noShowReason_' + playerId).val();

        console.log(information);

        Swal.fire({
            title: 'Deseja atualizar os dados desse jogador?',
            showDenyButton: true,
            confirmButtonText: `Sim`,
            denyButtonText: `Cancelar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                var request = $.ajax({
                    url: '{{ url("/") }}' + '/api/team-has-player/save/team/' + matchId + '/player/' + playerId,
                    method: "POST",
                    data: information,
                });

                request.done(function() {
                    Swal.fire({
                        title: 'Pronto!',
                        text: 'A alteração foi realizada com sucesso',
                        type: 'success',
                        buttons: true,
                    }).then((buttonClick) => {
                        if (buttonClick) {
                            //location.reload();
                        }
                    });
                });

                request.fail(function( ) {
                    Swal.fire(
                        'Erro',
                        'Algum problema aconteceu, certifique-se de que a conexão com a internet esteja OK e que você esteja logado no sistema.',
                        'error'
                    )
                });
            } else if (result.isDenied) {
                Swal.fire('Nenhum registro afetado', '', 'info')
            }
        });
    });
    </script>
@endsection