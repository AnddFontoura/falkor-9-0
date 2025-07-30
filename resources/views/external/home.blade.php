@extends('layouts.external')

@section('content_external')
    <!-- Header -->
    <header class="header-background py-5">
        <div class="container text-justified">
            <div class="row">
                <div class="col-md-8 col-lg-8 col-sm-12 mt-5 ">

                </div>

                <div class="col-md-4 col-lg-4 col-sm-12 mt-5 translucid-background">
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

    <section class="py-5" id="mainResources">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h1 class="text-center mb-4">Recursos Principais</h1>
                </div>

                <div class="card-body">
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
            </div>
        </div>
    </section>

    <!-- Rodapé -->
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p>&copy; 2025 Sistema de Futebol</p>
        </div>
    </footer>
@endsection
