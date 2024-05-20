@extends('layouts.adminlte')

@section('content_adminlte')

<link rel="stylesheet" href="{{ asset('lightbox2/src/css/lightbox.css') }}">

@php
    $fieldName = $field->name ?? old('fieldName');
    $action = isset($field) ? 'Atualizar' : 'Criar';
@endphp

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.field.index') }}" class="btn btn-primary">Listar Campos</a>
    </div>

    <div class="col-12 mt-3">
        <form action="{{ route('system.field.upload_photo', [$field->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="callout callout-success">
                <h1> Adicionar fotos </h1>

                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 mt-3">
                        <div class="form-group">
                            <label for="fieldPhoto">Fotos<span class="text-danger">*</span></label>
                            <input type="file" class="form-control" id="fieldPhoto" name="photos[]" multiple>
                        </div>
                    </div> 
                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <input type="submit" class="btn btn-success btn-lg" value="Adicionar">
                    </div>
                </div>
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
                </div>      
            </div>
        </form>

        <div class="card text-center">
                    <div class="card-header">
                        {{ $field->name }}
                    </div>
                    <div class="card-body d-flex flex-wrap justify-content-center">
                        @if($photosFromField->count() > 0)  
                            @foreach($photosFromField as $photo)
                                @php
                                    $photo = 'storage/' . $photo->photo;
                                @endphp
                                
                                <div class='col-md-3 col-lg-3 col-sm-12'>
                                    <a onclick="" href="{{ asset(ltrim($photo, "/")) }}" data-lightbox="roadtrip">
                                        <img style="width:300px; height:300px;" src="{{ asset(ltrim($photo, "/")) }}" class='img w-100 photos img-thumbnail'></img>
                                    </a>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 mt-3">
                                    <div class='alert alert-danger'> Desculpe... Não tem fotos por aqui :\ </div>
                            </div>
                        @endif
                    </div>
                    <div class="card-footer text-muted">
                        
                    </div>
                </div>
    </div>
</div>

<script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lightbox2/src/js/lightbox.js') }}"></script>

@endsection