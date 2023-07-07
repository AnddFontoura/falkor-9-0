@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.team.save') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> Novo Time </h1>

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

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamCity">Cidade do time</label>
                            <select class="form-control select2bs4" id="teamCity" name="cityId">
                                @foreach($cities as $city)
                                <option value="{{ $city->id }}">{{ $city->name }} ({{ $city->stateInfo->short }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamBirth">Fundação do Time</label>
                            <input type="date" class="form-control" id="teamBirth" name="foundationDate">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="teamName">Nome do time</label>
                            <input type="text" class="form-control" id="teamName" name="name" placeholder="Nome do time">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <div class="form-group">
                            <label for="teamDescription">Descrição</label>
                            <textarea class="form-control summernote" name="description" id="teamDescription"></textarea>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamLogo">Logo do Time</label>
                            <input type="file" class="form-control" id="teamLogo" name="logo">
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="teamBanner">Banner do Time</label>
                            <input type="file" class="form-control" id="teamBanner" name="banner">
                        </div>
                    </div>

                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="Cadastrar time">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection