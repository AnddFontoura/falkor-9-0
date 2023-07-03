@extends('layouts.adminlte')

@section('content_adminlte')
<div class="container mt-3">
    @if(count($listData) > 0)

    @else
    <div class='alert alert-danger'> Nenhum Time cadastrado </div>
    @endif
</div>
@endsection