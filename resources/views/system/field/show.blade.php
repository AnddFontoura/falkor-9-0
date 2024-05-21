@extends('layouts.adminlte')

@section('content_adminlte')

<link rel="stylesheet" href="{{ asset('lightbox2/src/css/lightbox.css') }}">

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.field.index') }}" class="btn btn-primary"> Listar Campos </a>
</div>
    @php
        $fieldPhotoPath = null;

        if($field->photos->isNotEmpty()) {
            $fieldPhotoPath = 'storage/' . $field->photos->first()->photo;
        }
    @endphp

    <div class="col-12 mt-3">
        <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info"
                style="
                        background-image: url('{{ asset(ltrim($fieldPhotoPath, '/')) }}');
                        background-position: center;
                        background-size: 100%
                    "
            >
            </div>
            <div class="widget-user-image">
                <img class="img-circle elevation-2" src="" alt="User Avatar">
            </div>
            <div class="card-footer">
                <div class="row">
                    <div class="col-sm-6 border-right">
                        <div class="description-block">
                            <h5 class="description-header">{{ $field->name }}</h5>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="description-block">
                            <h5 class="description-header">{{ $field->cityInfo->name }}</h5>
                            <span class="description-text">{{ $field->cityInfo->stateInfo->name }}</span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex">
                <h4 class="col-md-6">Fotos do campo</h4>
                <form class="d-flex justify-content-end col-md-6" action="{{ route('system.field.upload_photo_form', [$field->id]) }}">
                    @csrf
                    <button class="btn btn-primary">Adicionar fotos</button>
                </form>
            </div>

            <div class="card-body">
                <div class="row">

                    @if($photos->count() > 0)
                        @foreach($photos as $photo)
                            @php
                                $photo = 'storage/' . $photo->photo;
                            @endphp
                            <div class='col-md-3 col-lg-3 col-sm-12'>
                                <a onclick="" href="{{ asset(ltrim($photo, "/")) }}" data-lightbox="roadtrip">
                                    <img style="width:600px; height:400px;" src="{{ asset(ltrim($photo, "/")) }}" class='img w-100 photos img-thumbnail'></img>
                                </a>
                            </div>
                        @endforeach
                    @endif
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lightbox2/src/js/lightbox.js') }}"></script>

@endsection