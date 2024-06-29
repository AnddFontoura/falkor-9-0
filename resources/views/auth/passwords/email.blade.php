@extends('layouts.app')

@section('content_adminlte')
<div class="login-box">
    <div class="login-logo">
        <a href="{{ url('/') }}"> <b> SBFA-FALKOR </b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                {{ __('auth.form.password_recovery_info') }}
            </p>

            <form action="{{ route('password.email') }}" method="post">
                @csrf

                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                <div class="form-group mb-3">
                    <input
                        type="email"
                        class="form-control"
                        name="email"
                        placeholder="Email"
                    >
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __("auth.form.button.new_password_request_submit")  }}
                        </button>
                    </div>
                </div>
            </form>

            <p class="mt-3 mb-1">
                <a href="{{ route('login') }}">
                    {{ __("auth.form.button.login_submit")  }}
                </a>
            </p>
            <p class="mb-0">
                <a href="{{ route('register') }}" class="text-center">
                    {{ __('auth.form.register_a_new_membership') }}
                </a>
            </p>
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->

@endsection
