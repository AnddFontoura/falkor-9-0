@extends('layouts.adminlte')

@section('content_adminlte')
<div class='row'>
    <div class="col-12 p-1">
        <a href="{{ route('system.matches.form_create', [$teamId]) }}" class='btn btn-success'> Cadastrar time </a>
    </div>

    <div class="col-12 p-1">
        <form action="{{ route('system.team.index') }}" method="GET">
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
        @php
            $homeTeamBanner = "";
        @endphp
        <div class="col-12 d-flex align-items-stretch">
            <div class="card w-100 shadow bg-light color-palette">
            
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