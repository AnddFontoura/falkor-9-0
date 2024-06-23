@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.matches.form_create', [$team->id]) }}" class='btn btn-success'> Cadastrar partida </a>
        <a href="{{ route('system.team.manage', [$team->id]) }}" class='btn btn-primary'> Administrar Time </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.team.matches', $team->id) }}" method="GET">
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
        <div class="col-md-4">

            <div class="card card-widget widget-user">
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6 border-right">
                            <div class="description-block">
                                <h5 class="description-header"> {{ $match->home_team_name }} </h5>
                                <span class="description-text"> {{ $match->home_score ?? 'Sem Resultado' }}</span>
                            </div>

                        </div>

                        <div class="col-sm-6">
                            <div class="description-block">
                                <h5 class="description-header">{{ $match->visitor_team_name }}</h5>
                                <span class="description-text">{{ $match->visitor_score ?? 'Sem Resultado' }}</span>
                            </div>

                        </div>

                        <div class="col-sm-12 border-top">
                            <div class="description-block">
                                <h5 class="description-header">Partida em</h5>
                                <span class="description-text">{{ $match->schedule->format('d/m/Y H:i') }}</span>
                                <div class="btn-group-vertical w-100 mt-1">
                                    <a href="{{ route('system.matches.form_update', [$team->id, $match->id]) }}" class="btn btn-lg w-100 btn-warning"> Editar Jogo</a>
                                    <a href="{{ route('system.match-players.form', [$team->id, $match->id]) }}" class="btn btn-lg w-100 btn-secondary"> Editar Jogadores</a>
                                    <a href="{{ route('system.matches.show', [$team->id, $match->id]) }}" class="btn btn-lg w-100 btn-primary"> Visualizar Jogo</a>
                                </div>
                             </div>
                        </div>
                    </div>
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
