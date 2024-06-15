<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title> SBFA </title>
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sbfa.css') }}">
    <link rel="stylesheet" href="{{ asset('lightbox2/src/css/lightbox.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap3.min.css">

</head>

<body class="container-fluid">
    <nav class="fixed-top navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">SBFA</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/#mainResources">Recursos Principais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/#systemImages">Imagens do Sistema</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('external.teams') }}">Times</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('external.players') }}">Jogadores</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('external.matches') }}">Partidas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/#contact">Fale Conosco</a>
                    </li>
                </ul>
            </div>
            <div class="navbar-nav ms-auto btn-group">
                @auth
                    <a href="{{ url('/home') }}" class="btn btn-primary">Home</a>
                @else
                    @if (Route::has('login'))
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#loginModal">
                            Logar
                        </button>
                    @endif

                    @if (Route::has('register'))
                        <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#newAccountModal">
                            Criar Conta
                        </button>
                        @endif
                        @endauth
                        </ul>
            </div>
        </div>
    </nav>
    @yield('content_external')

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModal" aria-hidden="true">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Login </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">
                                Email
                            </label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-md-4 col-form-label text-md-end">
                                Senha
                            </label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (Route::has('password.request'))
                            <a class="btn btn-link float-start" href="{{ route('password.request') }}">
                                Esqueceu sua senha?
                            </a>
                        @endif

                        <button type="submit" class="btn btn-primary float-end">
                            Logar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <div class="modal fade" id="newAccountModal" tabindex="-1" aria-labelledby="newAccountModal" aria-hidden="true">
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"> Registrar </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-3">
                            <label for="registerName" class="col-md-4 col-form-label text-md-end">
                                Nome
                            </label>

                            <div class="col-md-6">
                                <input id="registerName" type="text" class="form-control @error('registerName') is-invalid @enderror" name="registerName" value="{{ old('registerName') }}" required autocomplete="registerMame" autofocus>

                                @error('registerName')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="registerEmail" class="col-md-4 col-form-label text-md-end">
                                Email
                            </label>

                            <div class="col-md-6">
                                <input id="registerEmail" type="email" class="form-control @error('registerEmail') is-invalid @enderror" name="registerEmail" value="{{ old('registerEmail') }}" required autocomplete="registerEmail">

                                @error('registerEmail')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="registerPassword" class="col-md-4 col-form-label text-md-end">
                                Senha
                            </label>

                            <div class="col-md-6">
                                <input id="registerPassword" type="password" class="form-control @error('registerPassword') is-invalid @enderror" name="registerPassword" required autocomplete="registerPassword">

                                @error('registerPassword')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="registerPassword-confirm" class="col-md-4 col-form-label text-md-end">
                                Confirme a senha
                            </label>

                            <div class="col-md-6">
                                <input id="registerPassword-confirm" type="password" class="form-control" name="registerPassword_confirmation" required autocomplete="registerPassword">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary float-end">
                            Registrar
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('bootstrap/js/jquery.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.10.2/umd/popper.min.js"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('lightbox2/src/js/lightbox.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>

    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('#select-multiple').selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                create: false
            });
        });

        $(document).ready(function(){
            @if($errors->has('email') || $errors->has('password'))
            $('#loginModal').modal('show');
            @endif

            @if($errors->has('registerEmail') || $errors->has('registerPassword') || $errors->has('registerName'))
            $('#newAccountModal').modal('show');
            @endif
        });
    </script>
</body>
</html>
