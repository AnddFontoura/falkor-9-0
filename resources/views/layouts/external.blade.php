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
                        <a class="nav-link active" aria-current="page" href="#mainResources">Recursos Principais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#systemImages">Imagens do Sistema</a>
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
                        <a class="nav-link active" aria-current="page" href="#contact">Fale Conosco</a>
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
