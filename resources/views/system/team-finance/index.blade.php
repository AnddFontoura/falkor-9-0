@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        // Ajusta os dados para exibir no formulario antes de exibir
        $fieldValue = $fieldValueInfo->value ?? old('fieldValue');
        $refereeValue = $refereeValueInfo->value ?? old('refereeValue');
        $otherValue = $otherValueInfo->value ?? old('otherValue');
        $otherDescription = $otherValueInfo->description ?? old('otherDescription');
    @endphp
    <div class="row">
        <div class="col-12 mt-3">
            <a
                href="{{ route('system.matches.form_create', [$team->id]) }}"
                class='btn btn-success'
            >
                Cadastrar dado financeiro
            </a>

            <a
                href="{{ route('system.team.manage', [$team->id]) }}"
                class='btn btn-primary'
            >
                Administrar Time
            </a>
        </div>

        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
            <div class="info-box">
                <span class="info-box-icon bg-warning">
                    <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"> Débitos </span>
                    <span class="info-box-number"> R$ {{ number_format($debitAmount, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 mt-3">
            <div class="info-box">
                <span class="info-box-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"> Créditos </span>
                    <span class="info-box-number"> R$ {{ number_format($creditAmount, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="col-lg-4 col-md-4 mt-3">
            <div class="info-box">
                <span class="info-box-icon bg-danger">
                    <i class="fas fa-dollar-sign"></i>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"> Total </span>
                    <span class="info-box-number"> R$ {{ number_format($total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> Partida</th>
                                <th> Jogador </th>
                                <th> Origem </th>
                                <th class="text-right"> Valor </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($teamFinances as $finance)
                                <tr>
                                    <td>
                                        <a href="{{ route('system.match.view', $finance->match_id) }}">
                                            <p>
                                                {{ $finance->matchInfo->schedule->format('d/m/Y') ?? '' }}
                                                <br>
                                                <span class="text-muted">
                                                    {{ $finance->matchInfo->schedule->format('h:i') ?? 'Sem partida' }}
                                                </span>
                                            </p>
                                        </a>
                                    </td>

                                    <td>
                                        @if($finance->team_player_id)
                                            <p>
                                                {{ $finance->teamPlayerInfo->name }}
                                                <br>
                                                <span class="text-muted">
                                                    {{ $finance->teamPlayerInfo->nickname }}
                                                </span>
                                            </p>
                                        @else
                                            <p class="text-muted"> Sem jogador </p>
                                        @endif
                                    </td>

                                    <td>
                                        {{ __($finance->origin) }}
                                    </td>

                                    <td>
                                        <p class="@if($finance->type == 0) text-danger @else text-success @endif text-success text-right">
                                            @if($finance->type == 0) - @endif R$ {{ number_format($finance->value, 2, ',', '.') }}
                                        </p>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="card-footer">
                    {{ $teamFinances->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
