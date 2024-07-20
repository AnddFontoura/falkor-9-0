@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12">
            <div class="row">
                <div class="col-lg-2 col-md-3 col-sm-6 mt-3">
                    <a
                        href="{{ route('system.friendly-match.index') }}"
                        class="btn btn-primary"
                    >
                        Listar Amistosos
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

                        <div class="col-md-6 col-sm-12 mt-3">
                            <h3> Cidade da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->cityInfo->name }}
                            </p>
                        </div>

                        <div class="col-md-6 col-sm-12 mt-3">
                            <h3> Estado da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->cityInfo->stateInfo->name }}
                            </p>
                        </div>

                        <div class="col-md-4 col-sm-12 mt-3">
                            <h3> Data da partida </h3>
                            <p class="text-muted">
                                {{ $friendlyGame->matchStart->format('d/m/Y') }} -
                                {{ $friendlyGame->start_at }}
                            </p>
                        </div>

                    </div>
                </div>

                @if (count($ownedTeams) > 0)
                    <div class="card-footer">
                        <form action="" method="POST">
                            <div class="row">
                                <div class="col-md-6 col-sm-12 form-group">
                                    <select class="form-control w-100">

                                    </select>
                                </div>
                                <div class="col-md-6 col-sm-12 form-group">
                                    <input
                                        type="submit"
                                        class="btn btn-success w-100"
                                        value="Propor partida"
                                    >
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
