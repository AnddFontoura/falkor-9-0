@extends('layouts.adminlte')

@section('content_adminlte')
    <div class='row'>
        <div class="col-12 p-1">
            <form id="searchForm" action="{{ route('admin.game-position.index') }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar posições
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gamePositionId">ID</label>
                                    <input type="number" class="form-control" id="gamePositionId" name="gamePositionId" placeholder="Id da posição" value="{{ Request::get('userId') ?? '' }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="gamePositionName">Nome</label>
                                    <input type="text" class="form-control" id="gamePositionName" name="gamePositionName" placeholder="Nome da posição" value="{{ Request::get('userName') ?? '' }}">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <input type="submit" id="searchButton" class="btn btn-primary" value="Filtrar posições">
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12">
            <a href="{{ route('admin.game-position.create') }}" class="btn btn-success">
                Criar uma nova posição
            </a>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h1>Lista de posições</h1>
                </div>

                <div class="card-body">
                    @if(count($gamePositions) > 0)
                        <table class="table table-responsive-sm table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Nome</th>
                                    <th scope="col">Ícone</th>
                                    <th scope="col" class="text-right">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($gamePositions as $gamePosition)
                                <tr>
                                    <td>
                                        {{ $gamePosition->id }}
                                    </td>
                                    <td>
                                        {{ $gamePosition->name }}
                                    </td>
                                    <td>
                                        {!! $gamePosition->icon !!}
                                    </td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.game-position.edit', $gamePosition->id) }}" class="btn btn-warning" title="Editar"> <i class="fas fa-user-edit"></i> </a>
                                        <a href="{{ route('admin.game-position.show', $gamePosition->id) }}" class="btn btn-primary" title="Visualizar"> <i class="fas fa-eye"></i> </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class='alert alert-danger'> Nenhum usuário cadastrado </div>
                    @endif
                </div>

                <div class="card-footer">
                    {{ $gamePositions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
