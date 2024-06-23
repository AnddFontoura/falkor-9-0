@extends('layouts.adminlte')

@section('content_adminlte')
@php
    $action = isset($gamePosition) ?
        route('admin.game-position.update', [$gamePosition->id])
        : route('admin.game-position.save');

    $gamePositionName = isset($gamePosition) ?
        $gamePosition->name
        : old('gamePositionName');

    $gamePositionShort = isset($gamePosition) ?
        $gamePosition->short
        : old('gamePositionShort');

    $gamePositionIcon = isset($gamePosition) ?
        $gamePosition->icon
        : old('$gamePositionIcon');

    $actionText = isset($gamePosition) ?
        'Atualizar'
        : 'Cadastrar';
@endphp
    <div class='row'>
        <div class="col-12 mt-3">
            <a
                href="{{ route('admin.game-position.index') }}"
                class="btn btn-primary"
            >
                Voltar a lista de posições
            </a>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ $action }}" method="POST">
                @csrf

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @if ($errors->any())
                                <div class="col-12 alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="gamePositionName">Nome</label>
                                    <input
                                        name="gamePositionName"
                                        type="text"
                                        class="form-control"
                                        id="gamePositionName"
                                        placeholder="Nome da Posição"
                                        value="{{ $gamePositionName }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="form-group">
                                    <label for="gamePositionShort">Abreviação</label>
                                    <input
                                        name="gamePositionShort"
                                        type="text"
                                        class="form-control"
                                        id="gamePositionShort"
                                        placeholder="Abreviação da Posição"
                                        value="{{ $gamePositionShort }}"
                                        required
                                    >
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <label for="gamePositionIcon">Ícone</label>
                                    <input
                                        name="gamePositionIcon"
                                        type="text"
                                        class="form-control"
                                        id="gamePositionIcon"
                                        placeholder="Ícone da Posição"
                                        value="{{ $gamePositionIcon }}"
                                        required
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input
                            type="submit"
                            class="btn btn-success"
                            value="{{ $actionText }} Posição"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
