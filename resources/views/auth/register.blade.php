@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('content_adminlte')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/') }}"><b>SBFA - FALKOR</b></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __('auth.form.register_a_new_membership') }}</p>
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="{{ __('auth.form.full_name') }}"
                        name="name"
                        value="{{ old('name') }}"
                        required
                    >
                </div>
                <div class="form-group mb-3">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        name="email"
                        value="{{ old('email') }}"
                        required
                    >
                </div>
                <div class="form-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="{{ __('auth.form.password') }}"
                        name="password"
                        required
                    >
                </div>
                <div class="form-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="{{ __('auth.form.retype_password') }}"
                        name="password_confirmation"
                        required
                    >
                </div>
                <div class="row">
                    <div class="col-8">
                        <a href="{{ route('login') }}" class="text-center">
                            {{ __('auth.form.i_already_have_a_membership') }}
                        </a>
                    </div>
                    <!-- /.col -->
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('auth.form.button.register_submit') }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
