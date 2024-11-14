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

                <a href="/home" class="logo">
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
                                    <img src="\img\perfil_dos.png"
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
                                                    <h4>{{ auth()->user()->name }}</h4>
                                                    <p class="text-muted">{{ auth()->user()->email }}</p>
                                                </div>
                                            </div>
                                        </li>
                                        <li>                                        
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#" data-toggle="modal"
                                                data-target="#logoutModal">Cerrar sesión</a>
                                        </li>
                                    </div>
                                    <div class="scroll-element scroll-x">
                                        <div class="scroll-element_outer">
                                            <div class="scroll-element_size"></div>
                                            <div class="scroll-element_track"></div>
                                            <div class="scroll-bar ui-draggable ui-draggable-handle"></div>
                                        </div>
                                    </div>
                                    <div class="scroll-element scroll-y">
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
                            <img src="\img\perfil_uno.png"
                                alt=".." class="avatar-img rounded-circle">
                        </div>
                        <div class="info">
                            <a data-toggle="collapse" href="#logoutDropdown" aria-expanded="false" class="collapsed">
                                <span>
                                    <span class="username">{{ auth()->user()->name }}</span>
                                    <span class="user-level text-uppercase">{{ auth()->user()->role->name_rol}}</span>
                                    <span class="caret"></span>
                                </span>
                            </a>
                            <div class="clearfix"></div>

                            <div class="in collapse" id="logoutDropdown">
                                <ul class="nav">
                                    <li>
                                        <a class="nav-link" href="" data-toggle="modal"
                                            data-target="#logoutModal">
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
                            <h4 class="text-section">Gestión de plan de aula</h4>
                        </li>

                        <!-- nav-bar list faculties -->
                        <li class="nav-item {{ request()->routeIs('faculties') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('faculties') }}">
                                <i class="fas fa-file-alt"></i>
                                <p>Gestionar plan de aula</p>
                            </a>
                        </li>
                        <!-- end nav-bar list  faculties -->


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

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Cerrar sesión</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas cerrar sesión?
                </div>
                <div class="modal-footer">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-primary">Aceptar</button>
                    </form>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- END Modal -->

</body>

</html>