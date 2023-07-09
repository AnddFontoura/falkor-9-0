@extends('layouts.adminlte')

@section('content_adminlte')

<div class='row'>
    <div class="col-12 mt-3">
        <a href="{{ route('system.team.index') }}" class="btn btn-primary"> Listar Times </a>
    </div>

    <div class="col-12 mt-3">
        <div class="callout callout-info">
            <div class="row">
                @if($team->banner_path != '')
                    @php
                        $bannerPath = asset('storage/' . $team->banner_path);
                    @endphp
                <div class="col-12 view-banner" style="background-image: url('{{ $bannerPath }}')">
                    
                </div>                    
                @endif

                <div class="col-6 mt-3">

                    @if($team->logo_path != '')
                        @php
                            $logoPath = asset('storage/' . $team->logo_path);
                        @endphp

                        <img class="img w-100 view-logo" src="{{ $logoPath }}">
                    @endif
                    
                    <h1 class="text-center"> {{ $team->name }} </h1>
                    <h4 class="text-center"> {{ $team->cityInfo->name }} </h4> 
                    <h6 class="text-center"> {{ $team->cityInfo->stateInfo->name }} </h6> 
                </div>

                <div class="col-6 mt-3 text-justify">
                    {!! $team->description !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection