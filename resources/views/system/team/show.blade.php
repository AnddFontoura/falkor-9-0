@extends('layouts.adminlte')

@section('content_adminlte')

@php
    isset($team->logo_path) ?
        $logoPath = asset('storage/' . $team->logo_path)
        : $logoPath = asset('img/dragon.png');

    isset($team->banner_path) ?
        $bannerPath = asset('storage/' . $team->banner_path)
        : $bannerPath = asset('img/synthetic_grass.png');
@endphp
<div class='row'>
    <div class="col-12">
        <div class="row">
            <div class="col-lg-2 col-md-4 col-sm-12 mt-3">
                <a
                    href="{{ route('system.team.index') }}"
                    class="btn btn-primary w-100"
                >
                    Listar Times
                </a>
            </div>
        </div>
    </div>

    @if(count($teamSearchPositions) > 0)
        <div class="col-12 mt-3">
            <div class="alert alert-dark">
                Esse time está procurando jogadores das seguintes posições para composição do elenco:

                <div class="row mt-3">
                    @foreach ($teamSearchPositions as $position)
                        <div class="col-lg-1 col-md-2 col-sm-4">
                            {!! $position->gamePositionInfo->icon !!}
                        </div>
                    @endforeach
                </div>

                @if($userBelongsToTeam)
                <div
                    class="btn btn-secondary w-100"
                    id="btnTeamApply"
                >
                    Clique aqui caso você queira se por a disposição para jogar por esse time.
                </div>
                @endif
            </div>
        </div>
    @endif

    <div class="col-md-6 col-lg-6 col-sm-12 text-justify mt-3">
        <div class="card">
            <div class="card-header">
                Sobre
            </div>

            <div class="card-body">
                {!! $team->description !!}
            </div>
        </div>
    </div>

    <div class="col-md-6 col-lg-6 col-sm-12 text-justify mt-3">
        @if(count($teamPlayers) > 0)
        <div class="card">
            <div class="card-header">
                Jogadores
            </div>

            <div class="card-body">
                <table class="table table-striped">
                    <tbody>
                        @foreach($teamPlayers as $player)
                            <tr>
                                <td class='w-10'> {{ $player->number }} </td>
                                <td class='w-10'> {!! $player->gamePositionInfo->icon !!} </td>
                                <td>
                                    @if($player->profile_id)
                                        <a
                                            href="{{ route('system.player.show', $player->profile_id) }}"
                                            target="_blank"
                                        >
                                    @endif
                                        {{ $player->name }}
                                    @if($player->profile_id)
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('page_js')
    <script>
        $('#btnTeamApply').on('click', function() {
            let teamId = $(this).data('teamid');
            let userId = $(this).data('userid');

            Swal.fire({
               title: 'Atenção!',
               text: "Seu perfil será exibido ao dono do time que aceitará ou não sua aplicação. " +
                   "Você poderá checar o status da sua aplicação a qualquer momento no menu " +
                   "'Minhas Aplicações' dentro da área de jogadores. Você deseja enviar um pedido " +
                   "a esse time?",
               showDenyButton: true,
               confirmButtonText: `Sim, enviar pedido`,
               denyButtonText: `Não, cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                   var request = $.ajax({
                       url: '{{ route("system.team.index") }}' + '/api/team-has-player/save/team/' + teamId + '/player/' + userId,
                       method: "POST",
                       data: {}
                   });
                   request.done(function () {
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
                   request.fail(function () {
                       Swal.fire(
                           'Erro',
                           'Algum problema aconteceu, certifique-se de que a conexão com a internet esteja OK e que você esteja logado no sistema.',
                           'error'
                       )
                   });
               } else if (result.isDenied) {
                   Swal.fire('Nenhum pedido foi enviado', '', 'info')
               }
           });
        });
    </script>

@endsection
