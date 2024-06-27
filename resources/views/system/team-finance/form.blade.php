@extends('layouts.adminlte')

@section('content_adminlte')
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
            <form actio="" method="POST">
                <div class="card">
                    <div class="card-header">
                        Movimentação Financeira
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Tipo de Movimentação </span>
                                    <select class="form-control">
                                        @foreach($financeTypes as $key => $value)
                                            <option value="{{ $key }}">
                                                {{ __($value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Origem de Movimentação </span>
                                    <select class="form-control">
                                        @foreach($financeOrigins as $value)
                                            <option value="{{ $value }}">
                                                {{ __($value) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 col-lg-4 col-sm-12 mt-3">
                                <div class="form-group">
                                    <span> Jogador associado </span>
                                    <select class="form-control select2bs4">
                                        <option value="0"> -- Jogadores ativos -- </option>
                                        @foreach($teamPlayers as $player)
                                            <option value="{{ $player->id }}">
                                                {{ $player->name }} ({{ $player->nickname }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 mt-3">
                                <div class="form-group">
                                    <span> Descrição </span>
                                    <textarea class="form-control">

                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="text"
                            class="btn btn-success w-auto"
                            value="Cadastrar movimentação"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
