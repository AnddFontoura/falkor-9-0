@extends('layouts.adminlte')

@section('content_adminlte')
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
                                <p class="text-muted">Nome</p>
                                <p>{{ $gamePosition->name }}</p>
                            </div>
                        </div>

                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <p class="text-muted">Abreviação</p>
                                {{ $gamePosition->short }}
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <p class="text-muted">Ícone</p>
                                {!! $gamePosition->icon !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <a
                        href="{{ route('admin.game-position.edit', $gamePosition->id) }}"
                        class="btn btn-primary"
                    >
                        Editar posição
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
