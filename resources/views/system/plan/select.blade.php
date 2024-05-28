@extends('layouts.adminlte')

@section('content_adminlte')
<div class="row">
    @foreach($plans as $plan)
    <div class="col-md-3 col-sm-12 col-lg-3 mt-3 d-flex align-items-stretch">
        <div class="card">
            <div class='card-header'>
                {{ $plan->name }}
            </div>

            <div class='card-body'>
                {!! $plan->description !!}
            </div>

            <div class='card-footer'>
                <a href="{{ route('system.plans.payment', [$plan->id] ) }}" class='btn btn-success'> Escolher esse plano </a>
            </div>
        </div>
    </div>
    @endforeach
</div>
<!-- /.login-box -->
@endsection
