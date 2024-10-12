<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Falkor</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/adminlte.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/css/selectize.bootstrap3.min.css">
    <link rel="stylesheet" href="{{ asset('lightbox2/src/css/lightbox.css') }}">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('system.news.index') }}" class="nav-link">
                        {{ __('news.plural') }}
                    </a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('system.player.form_create') }}" class="nav-link">
                        Perfil de Jogador
                    </a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="far fa-bell"></i>
                        <span class="badge badge-warning navbar-badge">
                            0
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item">
                            <i class="fas fa-envelope mr-2"></i> 4 new messages
                            <span class="float-right text-muted text-sm">3 mins</span>
                        </a>
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('system.news.index') }}" class="dropdown-item dropdown-footer">
                            {{ __('news.see_all_news') }}
                        </a>
                    </div>
                </li>

                <li class="nav-item d-none d-sm-inline-block">
                    <a href="{{ route('system.user.form') }}" class="nav-link">{{ Auth::user()->name }}</a>
                </li>
            </ul>
        </nav>

        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ route('home') }}" class="brand-link text-center">
                <span class="brand-text font-weight-light"> Falkor - SBFA </span>
            </a>

            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if(Auth::user()->is_admin)
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <p>
                                        {{ __('admin.main-menu') }}
                                        <i class="fas fa-angle-left right"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.index') }}" class="nav-link">
                                            <p> <i class="fas fa-angle-right"></i> Dashboard</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.user.index') }}" class="nav-link">
                                            <p> <i class="fas fa-angle-right"></i> Usuários</p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.news.index') }}" class="nav-link">
                                            <p> <i class="fas fa-angle-right"></i> Notícias </p>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="nav nav-treeview" style="display: none;">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.game-position.index') }}" class="nav-link">
                                            <p> <i class="fas fa-angle-right"></i> Posições de jogo</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <p>
                                    {{ __('general.dashboard') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('system.team.index') }}" class="nav-link">
                                <p>
                                    {{ __('teams.plural') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('system.friendly-game.index') }}" class="nav-link">
                                <p>
                                    {{ __('friendly-game.plural') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('system.matches_wt.index') }}" class="nav-link">
                                <p>
                                    {{ __('matches.plural') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('system.player.index') }}" class="nav-link">
                                <p>
                                    {{ __('players.plural') }}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item mt-4">
                            <a class="btn btn-danger w-100" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                Deslogar
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            <section class="content">
                @if(session('error'))
                <div class="row">
                    <div class="col-12 p-1">
                        <div class="alert alert-danger"> {{ session('error')}} </div>
                    </div>
                </div>
                @endif

                @if(session('success'))
                <div class="row">
                    <div class="col-12 p-1">
                        <div class="alert alert-success"> {{ session('success')}} </div>
                    </div>
                </div>
                @endif

                @if(isset($team))
                    <div class="row">
                        @include('components.team.team_header', ['team' => $team])
                    </div>
                @endif

                @yield('content_adminlte')
            </section>
        </div>

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
        </footer>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>

    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://kit.fontawesome.com/0cc6f43f73.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
    <script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>
    <script src="{{ asset('lightbox2/src/js/lightbox.js') }}"></script>


    <script>
        $(function() {
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })

            $('.summernote').summernote()

            $('.select-multiple').selectize({
                plugins: ['remove_button'],
                delimiter: ',',
                persist: false,
                create: false
            });
        });
    </script>

    @yield('page_js')
</body>

</html>
