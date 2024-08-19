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

                <div class="card-footer">
                </div>
            </div>
            @if($team->id == $friendlyGame->team_id)
                @foreach()

                    @endforeach
            @else

            @endif
        </div>
    </div>
@endsection
