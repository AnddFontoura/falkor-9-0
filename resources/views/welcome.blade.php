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
</head>

<body class="container-fluid p-0">
    <nav class="fixed-top navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
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


    <!-- Header -->
    <header class="header-background py-5">
        <div class="container text-justified">
            <div class="row">
                <div class="col-md-6 col-lg-6 col-sm-12 mt-5 translucid-background">
                    <img src="{{ asset('img/logo.png') }}" class='img w-100'></img>
                    <p class="lead mt-3"> A Tecnologia finalmente chegou para o futebol amador!</p>
                    <p>
                        Que tal criar um ambiente digital para o seu time amador e controlar jogadores,
                        presença, partidas, uniformes, estatísticas, campeonatos, reserva de campos e
                        quadras tudo no mesmo lugar? Ser capaz ainda de controlar fluxo de caixa e até
                        cobrar os seus jogadores de maneira transparente! Conheça agora!
                    </p>
                    <a href="{{ route('register') }}" class="btn btn-success btn-lg w-100 m-0">Crie uma conta agora</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Recursos -->
    <section class="py-5" id="mainResources">
        <div class="container-fluid">
            <div class='alert alert-danger text-center'>
                <p> <b> Atenção! </b> </p>

                <p> Algumas funções estão em desenvolvimento e serão adicionadas em melhorias futuras, acompanhe as novidades
                    diariamente aqui em nossa página </p>
            </div>

            <h1 class="text-center mb-4">Recursos Principais</h1>
            <div class="row">
                <div class="col-md-4 col-lg-4 col-sm-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body -100">
                            <img src="{{ asset('img/teamsvs.png') }}" class='img w-100'></img>
                            <h3 class="card-title">Times</h3>
                            <p> É possível criar e gerir de forma gratuita até 3 times por conta.</p>
                            <p> Na tela de times você pode atribuir um escudo, cidade de fundação,
                                data e descrição além de outras funcionalidades. Seu time ainda pode
                                aparecer na lista de times disponíveis para amistosos de acordo com
                                agenda e muito mais!
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <img src="{{ asset('img/matchmaker.png') }}" class='img w-100'></img>
                            <h3 class="card-title">Partidas</h3>
                            <p>
                                Agende e gerencie partidas de forma simples. Mantenha um histórico de resultados,
                                desempenho dos atletas, cartões, camisas, pagamentos e muito mais!
                            </p>
                            <p>
                                Crie e cuide de uma agenda digital onde você pode encontrar times para partidas e
                                dessa maneira facilitar o cenário amador.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-lg-4 col-sm-12 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <img src="{{ asset('img/player.png') }}" class='img w-100'></img>
                            <h3 class="card-title">Jogadores</h3>
                            <p class="card-text">Acompanhe estatísticas de desempenho e resultados.</p>
                            <p> Você pode cadastrar o mesmo jogador em vários times diferentes de
                                maneira individual, atribuindo a ele diferentes posições, números
                                e características em cada um de seus times, além de acompanhar seu
                                rendimento.
                            </p>
                            <p>
                                Dificuldade de encontrar jogadores? Ou Times? Você pode criar um perfil
                                de atleta e se disponibilizar para times ou ainda como time, procurar um
                                jogador para preencher o elenco.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-6 col-sm-12">
                    <div class="card">
                        <div class="card-header bg-success text-white">
                            E no futuro?
                        </div>
                        <div class="card-body">
                            <p>
                                Pretendemos que seja possivel criar ligas, campeonatos, amistosos e até mesmo
                                reserva de campos tudo utilizando a nossa plataforma. Ela foi pensada para o Futebol de 11
                                mas também há planos de expandir para outras modalidades como o Futsal e o famoso Fut7.
                            </p>

                            <p>
                                Será possível também gerenciar o caixa da sua equipe, adicionar permissões para que outras
                                pessoas ajudem a controlar o time, anotar períodos de lesão e outros dados importantes para
                                gestão profissional de sua equipe.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Preços -->
    <section id="systemImages" class="bg-light py-5">
        <div class='alert alert-danger text-center'>
            <p> <b> Atenção! </b> </p>

            <p> Algumas funções estão em desenvolvimento e serão adicionadas em melhorias futuras, acompanhe as novidades
                diariamente aqui em nossa página </p>
        </div>

        <h1 class="text-center mb-4"> Algumas Imagens do Sistema</h1>
        <div class="row">
            <div class='col-md-3 col-lg-3 col-sm-12'>
                <a href="{{ asset('img/examples/example_1.png') }}" data-lightbox="roadtrip">
                    <img src="{{ asset('img/examples/example_1.png') }}" class='img w-100'></img>
                </a>
            </div>

            <div class='col-md-3 col-lg-3 col-sm-12'>
                <a href="{{ asset('img/examples/example_2.png') }}" data-lightbox="roadtrip">
                    <img src="{{ asset('img/examples/example_2.png') }}" class='img w-100'></img>
                </a>
            </div>

            <div class='col-md-3 col-lg-3 col-sm-12'>
                <a href="{{ asset('img/examples/example_3.png') }}" data-lightbox="roadtrip">
                    <img src="{{ asset('img/examples/example_3.png') }}" class='img w-100'></img>
                </a>
            </div>

            <div class='col-md-3 col-lg-3 col-sm-12'>
                <a href="{{ asset('img/examples/example_4.png') }}" data-lightbox="roadtrip">
                    <img src="{{ asset('img/examples/example_4.png') }}" class='img w-100'></img>
                </a>
            </div>
        </div>
        <!--div class="container">
            <h2 class="text-center mb-4">Planos e Preços</h2>
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Plano Básico</h3>
                            <p class="card-text">Recursos básicos para começar.</p>
                            <h4 class="card-title">$19<span class="text-muted">/mês</span></h4>
                            <a href="#signup" class="btn btn-primary">Inscreva-se</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Plano Padrão</h3>
                            <p class="card-text">Recursos avançados para gerenciamento completo.</p>
                            <h4 class="card-title">$49<span class="text-muted">/mês</span></h4>
                            <a href="#signup" class="btn btn-primary">Inscreva-se</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="card-title">Plano Premium</h3>
                            <p class="card-text">Recursos avançados e suporte premium.</p>
                            <h4 class="card-title">$99<span class="text-muted">/mês</span></h4>
                            <a href="#signup" class="btn btn-primary">Inscreva-se</a>
                        </div>
                    </div>
                </div>
            </div>
        </div-->
    </section>

    <!-- Contato -->
    <section id="contact" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Entre em Contato</h2>
            <div class="row">
                <div class="col-md-6 mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                <div class="mb-3">
                                    <label for="contactName" class="form-label">Nome</label>
                                    <input type="text" class="form-control" id="contactName" placeholder="Seu nome">
                                </div>
                                <div class="mb-3">
                                    <label for="contactEmail" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="contactEmail" placeholder="Seu e-mail">
                                </div>
                                <div class="mb-3">
                                    <label for="contactMessage" class="form-label">Mensagem</label>
                                    <textarea class="form-control" id="contactMessage" rows="3" placeholder="Sua mensagem"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Enviar</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p>&copy; 2022 Sistema de Futebol</p>
        </div>
    </footer>

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

    <script>
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
