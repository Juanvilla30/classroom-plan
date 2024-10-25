<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Aula Manager @yield('title')</title>

    <!-- Otros meta tags y título -->

    <!-- Core JS Files -->
    <script src="{{ asset('atlantis/assets/js/core/jquery.3.2.1.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/core/bootstrap.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js') }}"></script>
    <!-- jQuery Scrollbar -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
    <!-- Datatables -->
    <script src="{{ asset('atlantis/assets/js/plugin/datatables/datatables.min.js') }}"></script>
    <!-- Atlantis JS -->
    <script src="{{ asset('atlantis/assets/js/atlantis.min.js') }}"></script>
    <!-- Chart Circle -->
    <script src="{{ asset('atlantis/assets/js/plugin/chart-circle/circles.min.js') }}"></script>
    <!-- Chart JS-->
    <script src="{{ asset('atlantis/assets/js/plugin/chart.js/chart.min.js') }}"></script>
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ asset('atlantis/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js') }}"></script>
    <!-- JS de Aut. Emocional HUB -->
    <script src="{{ asset('js/admin.js') }}"></script>
    <!-- Fonts and icons -->
    <script src="{{ asset('atlantis/assets/js/plugin/webfont/webfont.min.js') }}"></script>

    <script>
        WebFont.load({
            google: {
                "families": ["Lato:300,400,700,900"]
            },
            custom: {
                "families": ["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands",
                    "simple-line-icons"
                ],
                urls: ["{{ asset('atlantis/assets/css/fonts.css') }}"]
            },
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link href="{{ asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('atlantis/assets/css/atlantis.css') }}" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

    @include('sweetalert::alert')

    <!-- Page Wrapper -->
    <div class="wrapper">
        <!-- Main Header -->
        <div class="main-header">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="blue">

                <a href="#" class="logo">
                    <img src="\img\logo_autonoma.svg" alt="navbar brand" class="navbar" width="90%" height="100%"
                        style="filter: grayscale(100%) brightness(0) invert(100%);">
                </a>

                <button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse"
                    data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon">
                        <i class="icon-menu"></i>
                    </span>
                </button>

                <button class="topbar-toggler more"><i class="icon-options-vertical"></i></button>

                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="icon-menu"></i>
                    </button>
                </div>

            </div>
            <!-- End Logo Header -->

            <!-- Navbar Header -->
            <nav class="navbar navbar-header navbar-expand-lg" data-background-color="blue2">

                <div class="container-fluid">

                    <ul class="navbar-nav topbar-nav ml-md-auto align-items-center">

                        <li class="nav-item dropdown hidden-caret">
                            <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"
                                aria-expanded="false">
                                <div class="avatar-sm">
                                    <img src="https://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/profile.jpg"
                                        alt="..." class="avatar-img rounded-circle">
                                </div>
                            </a>
                            <ul class="dropdown-menu dropdown-user animated fadeIn">
                                <div class="scroll-wrapper dropdown-user-scroll scrollbar-outer"
                                    style="position: relative;">
                                    <div class="dropdown-user-scroll scrollbar-outer scroll-content"
                                        style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 0px;">
                                        <li>
                                            <div class="user-box">
                                                <div class="avatar-lg"><img
                                                        src="https://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/profile.jpg"
                                                        alt="image profile" class="avatar-img rounded"></div>
                                                <div class="u-text">
                                                    <h4>Hizrian</h4>
                                                    <p class="text-muted">hello@example.com</p><a href="#"
                                                        class="btn btn-xs btn-secondary btn-sm">View Profile</a>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">My Profile</a>
                                            <a class="dropdown-item" href="#">My Balance</a>
                                            <a class="dropdown-item" href="#">Inbox</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Account Setting</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Logout</a>
                                        </li>
                                    </div>
                                    <div class="scroll-element scroll-x">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar ui-draggable ui-draggable-handle"></div>
                                        </div>
                                    </div>
                                    <div class="scroll-element scroll-y" >
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar ui-draggable ui-draggable-handle"></div>
                                        </div>
                                    </div>
                                </div>
                            </ul>
                        </li>

                    </ul>
                </div>

            </nav>
            <!-- End Navbar Header -->
        </div>
        <!-- End Main Header -->

        <!-- Sidebar -->
        <div class="sidebar sidebar-style-2">
            <div class="sidebar-wrapper scrollbar scrollbar-inner">
                <div class="sidebar-content">
                    <div class="user">
                        <div class="avatar-sm float-left mr-2">
                            <img src="https://themekita.com/demo-atlantis-lite-bootstrap/livepreview/examples/assets/img/profile.jpg"
                                alt=".." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#logoutDropdown" aria-expanded="false" class="collapsed">
                                <span>
                                    <span class="username">User</span>
                                    <span class="user-level text-uppercase">Rol</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="in collapse" id="logoutDropdown" >
                                <ul class="nav">
                                    <li>
                                        <a class="nav-link" href="" data-toggle="modal" data-target="#logoutModal">
                                            <span class="link-collapse">Cerrar sesión</span>
                                        </a>
                                        <form id="logout-form" action="" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-primary">

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Inicio</h4>
                        </li>

                        <li class="nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="fas fa-home"></i>
                                <p>Inicio</p>
                            </a>
                        </li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestión de usuarios</h4>
                        </li>

                        <!-- nav-bar list user -->
                        <li class="nav-item {{ request()->routeIs('user') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('user') }}">
                                <i class="fas fa-users"></i>
                                <p>Gestionar usuarios</p>
                            </a>
                        </li>
                        <!-- end nav-bar list  user -->

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestión de perfil de egreso</h4>
                        </li>

                        <li class="nav-item {{ request()->routeIs('profilesCompetenciesRa') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('profilesCompetenciesRa') }}">
                                <i class="fas fa-book"></i>
                                <p>Gestionar perfil de egreso</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('listProfilesCompetenciesRa') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('listProfilesCompetenciesRa') }}">
                                <i class="fas fa-list"></i>
                                <p>Listado de perfiles de egresos</p>
                            </a>
                        </li>

                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestión de plan de aula</h4>
                        </li>

                        <li class="nav-item {{ request()->routeIs('classroomPlan') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('classroomPlan') }}">
                                <i class="fas fa-book-reader"></i>
                                <p>Gestionar plan de aula</p>
                            </a>
                        </li>

                        <li class="nav-item {{ request()->routeIs('listClassroomPlan') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('listClassroomPlan') }}">
                                <i class="fas fa-list"></i>
                                <p>Listado de plan de aula</p>
                            </a>
                        </li>

                        <!-- nav-bar document -->
                        <li class="nav-section">
                            <span class="sidebar-mini-icon">
                                <i class="fa fa-ellipsis-h"></i>
                            </span>
                            <h4 class="text-section">Gestión de informes</h4>
                        </li>

                        <li class="nav-item {{ request()->routeIs('document') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('document')}}">
                                <i class="fas fa-file-alt"></i> <!-- Ícono de documento -->
                                <p>Gestionar informe</p>
                            </a>
                        </li>
                        <!-- end nav-bar document -->                        

                    </ul>
                </div>
            </div>
        </div>
        <!-- End Sidebar -->

        <!-- Contenido and footer -->
        <div class="main-panel">
            <div class="content">
                <div class="page-inner">
                    <!-- Begin Page Content -->
                    <div class="container-fluid">
                        @section('content')
                        <!-- CONTENIDO -->
                        @show
                    </div>
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <nav class="pull-left">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Help
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Licenses
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright ml-auto">
                        2024, made with <i class="fa fa-heart heart text-danger"></i> Copyright &copy; <a
                            href="#">AulaManager</a>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        </div>
        <!-- End Contenido and footer -->
    </div>
    <!-- End of Content Wrapper -->

</body>

</html>