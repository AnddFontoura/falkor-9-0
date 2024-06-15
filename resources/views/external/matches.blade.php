@extends('layouts.external')

@section('content_external')
    <div class='row'>
        <div class="col-12">
            <form action="{{ route('external.matches') }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar partidas
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="teamName">Nome do time</label>
                                    <input type="text" class="form-control" id="teamName" name="teamName" placeholder="Nome do time" value="{{ Request::get('teamName') ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" class="btn btn-primary" value="Filtrar partidas">
                    </div>
                </div>
            </form>
        </div>
        @if(count($matches) == 0)
            <div class="col-12 mt-3">
                <div class='alert alert-danger'> Nenhuma partida cadastrada </div>
            </div>
        @else
            @foreach($matches as $match)
                <div class="col-md-4 d-flex align-items-stretch mt-3">
                    <div class="card w-100 shadow bg-light color-palette">
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-sm-6 mt-3">
                                    <div class="description-block">
                                        <h5 class="description-header"> {{ $match->home_team_name }} </h5>
                                     </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="description-block">
                                        <h5 class="description-header">{{ $match->visitor_team_name }}</h5>
                                     </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="description-block">
                                        <span class="description-text"> {{ $match->home_score ?? 'Sem Resultado' }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-6 mt-3">
                                    <div class="description-block">
                                        <span class="description-text">{{ $match->visitor_score ?? 'Sem Resultado' }}</span>
                                    </div>
                                </div>

                                <div class="col-sm-12 mt-3">
                                    <div class="description-block">
                                        <h5 class="description-header">Partida em</h5>
                                        <span class="text-muted">
                                            {{ $match->cityInfo->name }} / {{ $match->cityInfo->stateInfo->short }}
                                            <br>
                                            {{ $match->schedule->format('d/m/Y H:i') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('system.matches_wt.show', [$match->id]) }}" class="btn w-100 btn-primary"> Visualizar Jogo</a>
                        </div>
                    </div>

                </div>
            @endforeach

            @if($matches->links())
                <div class="col-12 mt-3">
                    {{ $matches->withQueryString()->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection
