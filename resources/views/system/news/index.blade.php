@extends('layouts.adminlte')

@section('content_adminlte')
    <div class="row">
        <div class="col-12 mt-3">
            <form action="{{ route('system.news.index') }}" method="GET">
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
                        <div class="row">
                            @foreach($news as $new)
                                @php
                                    $newsImage = isset($new->header_image) ?
                                        asset('storage/' . $new->header_image)
                                        : asset('img/synthetic_grass.png');
                                @endphp

                                <div class="col-12 mt-3 border-bottom pb-3">
                                    <div class="row">
                                        <div
                                            class="col-4 text-center"
                                            style="
                                                background-image: url('{{ $newsImage }}');
                                                background-position: center;
                                                background-size: 100% cover;
                                            "
                                        >

                                            <a
                                                href="{{ route('system.news.show', $new->id) }}"
                                                class="btn btn-primary w-100"
                                            >
                                                Abrir Notícia
                                            </a>
                                        </div>

                                        <div class="col-8">
                                            <h2>
                                                {{ $new->title }}
                                            </h2>
                                            <p class="text-muted">
                                                {{ $new->created_at->format('d/m/Y H:i:s') }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                <div class="card-footer">
                    {{ $news->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
