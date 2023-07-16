@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    @if(count($playerInvitations) == 0)
        <div class='alert alert-danger'> Nenhum convite </div>
    @else
        @foreach($playerInvitations as $pi)
        <div class="col-md-4 col-lg-4 col-sm-12 p-1">
            <div class="card">
                <div class="card-header text-center">
                    <h3> {{ $pi->teamInfo->name }} </h3>
                </div>

                <div class="card-body">
                    <h5 class="card-text">{{ $pi->teamInfo->cityInfo->name }}</h5>
                    <h6 class="card-subtitle">{{ $pi->teamInfo->cityInfo->stateInfo->name }}</h6>
                </div>

                <div class="card-footer text-center">
                    <div class="btn-group">
                        <a href="{{ route('system.team.show', [$pi->teamInfo->id]) }}" title="Visualizar time" target="_BLANK" class="btn btn-lg btn-warning text-white">
                            <i class="far fa-eye"></i>
                        </a>

                        <div class="btn btn-lg btn-success btnAccept" data-inviteid="{{ $pi->id }}" title="Aceitar Convite">
                            <i class="far fa-thumbs-up"></i>
                        </div>

                        <div class="btn btn-lg btn-danger btnRefuse" data-inviteid="{{ $pi->id }}" title="Recusar convite">
                            <i class="fas fa-thumbs-down"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @if($playerInvitations->links())
        <div class="col-12 mt-3">
            {{ $playerInvitations->withQueryString()->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection

@section('page_js')
    <script>
        $('.btnAccept').on('click', function () {
            let invitationId = $(this).data('inviteid');

            Swal.fire({
                title: 'Atenção!',
                text: 'Você está prestes a aceitar o convite.',
                icon: "success",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, aceitar',
                cancelButtonText: 'Não, recusar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ route('system.player-invitation.accept') }}",
                        method: "POST",
                        data: {
                            invitationId: invitationId
                        },
                        dataType: "json"
                    });
                    request.done(function () {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'Seu convite foi aceito. Agora você pode consultar as informações do time',
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
                            'Algo deu errado ao aceitar esse convite. Tente novamente mais tarde ou entre em contato com o suporte',
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

        $('.btnRefuse').on('click', function () {
            let invitationId = $(this).data('inviteid');

            Swal.fire({
                title: 'Atenção!',
                text: 'Você está prestes a recusar o convite.',
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, recusar',
                cancelButtonText: 'Não, cancelar'
            }).then((result) => {
                if (result.value) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    var request = $.ajax({
                        url: "{{ route('system.player-invitation.accept') }}",
                        method: "POST",
                        data: {
                            invitationId: invitationId
                        },
                        dataType: "json"
                    });
                    request.done(function () {
                        Swal.fire({
                            title: 'Pronto!',
                            text: 'O convite foi recusado. Você não fará parte desse time.',
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
                            'Algo deu errado ao recusar esse convite. Tente novamente mais tarde ou entre em contato com o suporte',
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

