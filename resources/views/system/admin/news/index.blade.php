@extends('layouts.adminlte')

@section('content_adminlte')
    <div class="row">
        <div class="col-12 mt-3">
            <div class="row">
                <div class="col-md-4 col-lg-3 col-sm-6">
                    <a
                        href="{{ route('admin.news.create') }}"
                        class="btn btn-success"
                    >
                        Nova Notícia
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <form action="{{ route('admin.news.index') }}" method="GET">
                <div class="card">
                    <div class="card-header">
                        Filtrar noticias
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-lg-3 col-md-4 col-sm-12">
                                <span> Pesquisar por nome </span>
                                <input
                                    type="text"
                                    name="filterNewsName"
                                    placeholder="Nome parcial da noticia"
                                    minlength="3"
                                    class="form-control"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="submit"
                            class="btn btn-success"
                            value="Filtrar Noticias"
                        >
                    </div>
                </div>
            </form>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-body">
                    @if(count($news) == 0)
                        <div class="alert alert-danger">
                            Nenhuma notícia cadastrada
                        </div>
                    @else
                        <table class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th> Id </th>
                                    <th> Título </th>
                                    <th> Imagem </th>
                                    <th class="text-right"> Opções </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($news as $new)
                                    <tr>
                                        <td> {{ $new->id }}</td>
                                        <td> {{ $new->title }}</td>
                                        <td>
                                            @if($new->header_image)
                                                <button class="btn btn-success">
                                                    Sim
                                                </button>
                                            @else
                                                <button class="btn btn-danger">
                                                    Não
                                                </button>
                                            @endif
                                        </td>
                                        <td class="text-right">
                                            <a
                                                href="{{ route('admin.news.edit', $new->id) }}"
                                                class="btn btn-primary"
                                            >
                                                Editar
                                            </a>

                                            <a
                                                href="{{ route('admin.news.show', $new->id) }}"
                                                class="btn btn-secondary"
                                            >
                                                Visualizar
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>

                <div class="card-footer">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
