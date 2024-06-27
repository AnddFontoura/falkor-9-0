@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        $fieldValue = $fieldValueInfo->value ?? old('fieldValue');
        $refereeValue = $refereeValueInfo->value ?? old('refereeValue');
        $otherValue = $otherValueInfo->value ?? old('otherValue');
        $otherDescription = $otherValueInfo->description ?? old('otherDescription');
    @endphp
    <div class="row">
        <div class="col-12 mt-3">
            <a
                href="{{ route('system.team-finance.form', [$team->id]) }}"
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

        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
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

        <div class="col-lg-4 col-md-4 col-sm-12 mt-3">
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
                                <th class="text-center"> Ações </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($teamFinances as $finance)
                                @php
                                    $editUrl = isset($finance->match_id) ?
                                        route('system.team-finance.matches', [$team->id, $finance->match_id])
                                        : route('system.team-finance.form_update', [$team->id, $finance->id]);
                                @endphp
                                <tr>
                                    <td class="text-center">
                                        @if($finance->match_id)
                                        <a
                                            href="{{ route('system.matches.show', [$team->id, $finance->match_id]) }}"
                                            target="_blank"
                                        >
                                            <p>
                                                {{ $finance->matchInfo->schedule->format('d/m/Y') }}
                                                <br>
                                                <span class="text-muted">
                                                    {{ $finance->matchInfo->schedule->format('h:i') }}
                                                </span>
                                            </p>
                                        </a>
                                        @else
                                            <p class="text-muted"> Sem partida </p>
                                        @endif
                                    </td>

                                    <td>
                                        @if($finance->team_player_id)
                                            <a
                                                href="{{ route('system.team-player.show', [$team->id, $finance->team_player_id]) }}"
                                                target="_blank"
                                            >
                                                <p>
                                                    {{ $finance->teamPlayerInfo->name }}
                                                    <br>
                                                    <span class="text-muted">
                                                        {{ $finance->teamPlayerInfo->nickname }}
                                                    </span>
                                                </p>
                                            </a>
                                        @else
                                            <p class="text-muted"> Sem jogador </p>
                                        @endif
                                    </td>

                                    <td>
                                        <p>
                                            {{ __($finance->origin) }}
                                            @if($finance->description)
                                            <br>
                                                <span class="text-muted">
                                                    {{ $finance->description }}
                                                </span>
                                            @endif
                                        </p>
                                    </td>

                                    <td>
                                        <p class="@if($finance->type == 0) text-danger @else text-success @endif text-success text-right">
                                            @if($finance->type == 0) - @endif R$ {{ number_format($finance->value, 2, ',', '.') }}
                                        </p>
                                    </td>

                                    <td class="text-center"">
                                        <div class="btn-group">
                                            <a href="{{ $editUrl }}" class="btn btn-warning" title="Editar"> <i class="far fa-edit"></i> </a>
                                        </div>
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
