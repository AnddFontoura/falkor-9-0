@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        isset($news->header_image) ?
            $imagePath = asset('storage/' . $news->header_image)
            : $imagePath = asset('img/synthetic_grass.png');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-sm-12 mt-3">
                    <a
                        href="{{ route('admin.news.index') }}"
                        class="btn btn-primary"
                    >
                        Listar notícias
                    </a>
                </div>
            </div>
        </div>

        <div class="col-12 mt-3">
            <div class="card">
                <div class="card-header">
                    <h1> {{ $news->title }}</h1>
                </div>
                <div class="card-body">
                    <img src="{{ $imagePath }}" class="img-fluid float-left mr-3 mb-1" width="200px" alt="Imagem da Notícia">
                    {!! $news->content !!}
                </div>
                <div class="card-footer">
                    Visualizado: {{ $newsViews }}
                </div>
            </div>
        </div>
    </div>
@endsection
