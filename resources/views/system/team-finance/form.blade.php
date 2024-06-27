@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        $action = isset($teamFinanceInformation) ?
            route('system.team-finance.update', [$team->id, $teamFinanceInformation->id])
            : route('system.team-finance.save', [$team->id]);

        $financeOrigin = isset($teamFinanceInformation) ?
            $teamFinanceInformation->origin
            : old('financeOrigin');

        $financeType = isset($teamFinanceInformation) ?
            $teamFinanceInformation->type
            : old('financeType');

        $financePlayerId = isset($teamFinanceInformation) ?
            $teamFinanceInformation->team_player_id
            : old('financePlayerId');

        $financeDescription = isset($teamFinanceInformation) ?
            $teamFinanceInformation->description
            : old('financeDescription');

        $financeValue = isset($teamFinanceInformation) ?
            $teamFinanceInformation->value
            : old('financeValue');
    @endphp
    <div class="row">
        <div class="col-12 mt-3">
            <a
                href="{{ route('system.team-finance.index', [$team->id]) }}"
                class="btn btn-danger"
            >
                Financeiro
            </a>

            <a
                href="{{ route('system.team.manage', [$team->id]) }}"
                class="btn btn-primary"
            >
                Administrar time
            </a>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ $action }}" method="POST">
                @csrf
                <div class="card">
                    <div class="card-header">
                        Movimentação Financeira
                    </div>

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
                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Tipo de Movimentação </span>
                                    <select
                                        class="form-control"
                                        name="financeType"
                                    >
                                        @foreach($financeTypes as $key => $value)
                                            <option value="{{ $key }}" @if($financeType == $value) selected @endif>
                                                {{ __($value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Origem de Movimentação </span>
                                    <select
                                        class="form-control"
                                        name="financeOrigin"
                                    >
                                        @foreach($financeOrigins as $value)
                                            <option value="{{ $value }}" @if($financeOrigin == $value) selected @endif>
                                                {{ __($value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Jogador associado </span>
                                    <select
                                        class="form-control select2bs4"
                                        name="financePlayerId"
                                    >
                                        <option value="0"> -- Jogadores ativos -- </option>
                                        @foreach($teamPlayers as $player)
                                            <option value="{{ $player->id }}"  @if($financePlayerId == $player->id) selected @endif>
                                                {{ $player->name }} ({{ $player->nickname }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <span> Descrição </span>
                                    <textarea
                                        class="form-control"
                                        name="financeDescription"
                                    >{{ $financeDescription }}</textarea>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <span> Valor </span>
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="0000,00"
                                        pattern="[0-9]{1,6},[0-9]{1,2}"
                                        name="financeValue"
                                        value="{{ $financeValue }}"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="submit"
                            class="btn btn-success w-auto"
                            value="Cadastrar movimentação"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
