@extends('layouts.adminlte')

@section('content_adminlte')
    @php
        $action = isset($news)
            ? route('admin.news.update', $news->id)
            : route('admin.news.save');

        $actionName = isset($news)
            ? 'Atualizar'
            : 'Cadastrar';

        $newsTitle = isset($news)
            ? $news->title
            : old('newsTitle');

        $newsContent = isset($news)
            ? $news->content
            : old('newsContent');
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
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="card">
                    <div class="card-header">
                        {{$actionName}} Notícia
                    </div>

                    <div class="card-body">

                        @if ($errors->any())
                            <div class="col-12 alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 mt-3 form-group">
                                <span> Título da Notícia </span>
                                <input
                                    type="text"
                                    minlength="3"
                                    name="newsTitle"
                                    class="form-control"
                                    placeholder="Título da Notícia"
                                    value="{{ $newsTitle }}"
                                >
                            </div>

                            <div class="col-12 mt-3 form-group">
                                <span> Imagem da Notícia </span>
                                <input
                                    type="file"
                                    name="newsHeaderImage"
                                    class="form-control"
                                >
                            </div>

                            <div class="col-12 mt-3 form-group">
                                <span> Conteúdo da Notícia </span>
                                <textarea
                                    minlength="3"
                                    name="newsContent"
                                    class="form-control summernote"
                                >{{ $newsContent }}
                                </textarea>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <input
                            type="submit"
                            class="btn btn-success"
                            value="{{ $actionName }} Notícia"
                        >
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
