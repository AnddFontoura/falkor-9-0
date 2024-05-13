@extends('layouts.adminlte')

@section('content_adminlte')

<link rel="stylesheet" href="{{ asset('lightbox2/src/css/lightbox.css') }}">

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.field.index') }}" class="btn btn-primary"> Listar Campos </a>
</div>

    <div class="col-12 mt-3">
        <div class="card card-widget widget-user">
            <div class="widget-user-header bg-info"
                style="
                        background-image: url(https://www.costabravaclube.com.br/images/campo-de-futebol-8.jpg);
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
            <div class="card-header text-center">
                <h4>Fotos do campo</h4>
            </div>

            <div class="card-body">
                <div class="row">

                    <div class='col-md-3 col-lg-3 col-sm-12'>
                        <a onclick="" href="{{ asset('img/examples/example_1.png') }}" data-lightbox="roadtrip">
                            <img src="{{ asset('img/examples/example_1.png') }}" class='img w-100 photos'></img>
                        </a>
                    </div>
                    
                    <div class='col-md-3 col-lg-3 col-sm-12'>
                        <a href="https://fastly.4sqi.net/img/general/1398x536/eu-7X2_OMwah2pxlFIQy7Qcmp7SDtWhwLrF-JTddkzU.jpg" data-lightbox="roadtrip">
                            <img src="https://fastly.4sqi.net/img/general/1398x536/eu-7X2_OMwah2pxlFIQy7Qcmp7SDtWhwLrF-JTddkzU.jpg" class='img w-100 photos'></img>
                        </a>
                    </div>
                    
                    <div class='col-md-3 col-lg-3 col-sm-12'>
                        <a href="{{ asset('img/examples/example_3.png') }}" data-lightbox="roadtrip">
                            <img src="{{ asset('img/examples/example_3.png') }}" class='img w-100 photos'></img>
                        </a>
                    </div>
                    
                    <div class='col-md-3 col-lg-3 col-sm-12'>
                        <a href="{{ asset('img/examples/example_4.png') }}" data-lightbox="roadtrip">
                            <img src="{{ asset('img/examples/example_4.png') }}" class='img w-100 photos'></img>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
<script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('lightbox2/src/js/lightbox.js') }}"></script>

@endsection