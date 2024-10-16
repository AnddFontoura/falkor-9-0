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

                @if(!$userBelongsToTeam)
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

    <div class="col-12">
        <div class="row">
            @if(isset($team->social_profiles['facebook']) && !empty($team->social_profiles['facebook']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://facebook.com/{{ $team->social_profiles['facebook'] }}"
                    >
                        Facebook
                    </a>
                </div>
            @endif

            @if(isset($team->social_profiles['instagram']) && !empty($team->social_profiles['instagram']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://instagram.com/{{ $team->social_profiles['instagram'] }}"
                    >
                        Instagram
                    </a>
                </div>
            @endif

            @if(isset($team->social_profiles['tiktok']) && !empty($team->social_profiles['tiktok']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://tiktok.com/{{ $team->social_profiles['tiktok'] }}"
                    >
                        TikTok
                    </a>
                </div>
            @endif

            @if(isset($team->social_profiles['youtube']) && !empty($team->social_profiles['youtube']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://youtube.com/{{ $team->social_profiles['youtube'] }}"
                    >
                        Youtube
                    </a>
                </div>
            @endif

            @if(isset($team->social_profiles['x']) && !empty($team->social_profiles['x']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://x.com/{{ $team->social_profiles['x'] }}"
                    >
                        X
                    </a>
                </div>
            @endif

            @if(isset($team->social_profiles['kwai']) && !empty($team->social_profiles['kwai']))
                <div class="col-md-3 col-sm-6 mt-1">
                    <a
                        class="btn btn-success w-100"
                        target="_blank"
                        href="https://kwai.com/{{ $team->social_profiles['kwai'] }}"
                    >
                        Kwai
                    </a>
                </div>
            @endif
        </div>
    </div>

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
            const { value: gamePosition} = Swal.fire({
               title: 'Atenção!',
               text: "Seu perfil será exibido ao dono do time que aceitará ou não sua aplicação. " +
                   "Você poderá checar o status da sua aplicação a qualquer momento no menu " +
                   "'Minhas Aplicações' dentro da área de jogadores. Você deseja enviar um pedido " +
                   "a esse time e qual a posição escolhida?",
                input: "select",
                inputOptions: {
                   @foreach($teamSearchPositions as $position)
                        {{ $position->gamePositionInfo->id }}:"{{ $position->gamePositionInfo->name }}",
                   @endforeach
                },
               showDenyButton: true,
               confirmButtonText: `Sim, enviar pedido`,
               denyButtonText: `Não, cancelar`,
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                   var request = $.ajax({
                       url: '{{ route("api.team-application.save", [$team->id, Auth::user()->id]) }}',
                       method: "POST",
                       data: {
                           gamePositionId: result.value
                       },
                       dataType: "json"
                   });
                   request.done(function (response) {
                       Swal.fire({
                           title: 'Pronto!',
                           text: response.success,
                       })
                   });
                   request.fail(function (jqXHR, textStatus, errorThrown) {
                       Swal.fire(
                           'Erro',
                           jqXHR.responseJSON.error,
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
