@extends('layouts.app')

@section('content_adminlte')
<div class="register-box">
    <div class="register-logo">
        <a href="{{ url('/') }}"><b>SBFA - FALKOR</b></a>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">{{ __('auth.form.register_a_new_membership') }}</p>
            <form action="{{ route('register') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="col-12 alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="form-group mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="{{ __('auth.form.full_name') }}"
                        name="registerName"
                        value="{{ old('registerName') }}"
                        required
                    >

                    @error('registerName')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Email"
                        name="registerEmail"
                        value="{{ old('registerEmail') }}"
                        required
                    >

                    @error('registerEmail')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="{{ __('auth.form.password') }}"
                        name="registerPassword"
                        required
                    >

                    @error('registerPassword')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="{{ __('auth.form.retype_password') }}"
                        name="registerPassword_confirmation"
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
