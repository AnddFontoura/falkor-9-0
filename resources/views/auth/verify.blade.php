@extends('layouts.app')

@section('content_adminlte')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url('/') }}"> <b>SBFA - FALKOR</b></a>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">{{ __('auth.form.verify_your_email') }}</p>

                @if (session('resent'))
                    <div class="alert alert-success" role="alert">
                        <p>
                            {{ __('auth.verify_screen.e_mail_resent') }}
                        </p>
                    </div>
                @endif
                <p> {{ __('auth.verify_screen.before_proceeding_check_email') }}</p>
                <p> {{ __('auth.verify_screen.click_email_button') }} </p>

                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-primary p-0 mt-3 align-baseline w-100">
                        {{ __('auth.verify_screen.receive_other_email') }}
                    </button>
                </form>

            </div>
        </div>
    </div>
@endsection
