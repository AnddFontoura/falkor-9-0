@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        $thousandSeparator = __('general.numbers.thousand_separator');
        $decimalSeparator = __('general.numbers.decimal_separator');
        $moneyPattern = __('general.numbers.money_pattern');
    @endphp
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-4 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.team.manage', [$team->id]) }}"
                        class="btn bg-purple color-palette w-100"
                    >
                        Administrar Time
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-3">
                            <h1> {{ $friendlyGame->teamInfo->name }} </h1>
                        </div>

                        <div class="col-md-8 col-sm-12 mt-3">
                            <h3> Cidade da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->cityInfo->name }}
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-3">
                            <h3> Estado da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->cityInfo->stateInfo->name }}
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-3">
                            <h3> Data da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->match_date->format('d/m/Y') }} -
                                {{ $friendlyGame->start_at }}
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-3">
                            <h3> Duração da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->duration }}
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-3">
                            <h3> Preço da partida </h3>
                            <p class="text-muted">
                                {{ number_format($friendlyGame->price, 2, $decimalSeparator, $thousandSeparator) }}
                            </p>
                        </div>

                        <div class="col-12 mt-3">
                            <h3> Descrição da partida </h3>
                            <p class="text-muted">
                                {!! $friendlyGame->description !!}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    @if($team->id == $friendlyGame->team_id)
                        <table class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th>Nome do adversário</th>
                                    <th class="text-right">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($friendlyGameOpponents as $opponents)
                                    <tr>
                                        <td>
                                            <b>{{ $opponents->opponentInfo->name }}</b> <br>
                                            <span class="text-muted">
                                                {{ $opponents->opponentInfo->cityInfo->name }}
                                                ({{ $opponents->opponentInfo->cityInfo->stateInfo->short }})
                                            </span>
                                        </td>
                                        <td class="text-right">
                                            <a
                                                class="btn btn-sm btn-primary"
                                            >
                                                Perfil
                                            </a>
                                            <button
                                                class="btn btn-sm btn-success text-white"
                                            >
                                                Aprovar adversário?
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <table class="w-100 table table-striped">
                            <thead>
                                <tr>
                                    <th>
                                        Aprovado?
                                    </th>

                                    <th>
                                        Informação adicional
                                    </th>

                                    <th>
                                        Confirmar?
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                    <td>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page_js')
    <script>
        $('.btnAccept').on('click', function () {
            let friendlyGameId = $(this).data('friendlygameid');

            Swal.fire({
                title: 'Atenção!',
                text: 'Você deseja aceitar ou recusar esse oponente?.',
                html: '<select id="friendlyGameResult" class="swal2-select">' +
                    '<option value="0"> Não </option> ' +
                    '<option value="1"> Sim </option> '+
                    '</select>' +
                    '<label class="swal2-input-label"> Adicionar comentário (será exibido ao jogador) </label>' +
                    '<textarea id="friendlyGameDescription" class="swal2-textarea"></textarea>',
                preConfirm: () => {
                    return [
                        document.getElementById("friendlyGameResult").value,
                        document.getElementById("friendlyGameDescription").value
                    ];
                },
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Continuar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ route('system.team.friendly-game.resolve', [$team->id]) }}",
                        method: "POST",
                        data: {
                            friendlyGameId: friendlyGameId,
                            friendlyGameResult: result.value[0],
                            friendlyGameDescription: result.value[1]
                        },
                        dataType: "json"
                    });
                    request.done(function () {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'Seu amistoso foi atualizado! Iremos recarregar a página',
                            type: 'success',
                            buttons: true,
                        })
                            .then((buttonClick) => {
                                if (buttonClick) {
                                    location.reload();
                                }
                            });
                    });
                    request.fail(function () {
                        Swal.fire(
                            'Erro',
                            'Algo deu errado ao avaliar esse amistoso. Tente novamente mais tarde ou entre em contato com o suporte',
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
