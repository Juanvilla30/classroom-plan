@extends('layout.layout')

@section('title')

@section('content')

<div>

    <!-- Breadcumb Header -->
    <div style="margin-bottom: 20px">
        <ul class="breadcrumbs">
            <li class="nav-home">
                <a href="#">
                    <i class="fas fa-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Inicio</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Listado de perfiles de egreso</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Listado de perfiles de egreso</h5>
        </div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="selectProfileInformation">Seleccionar el tipo de perfil</label>
                    <select class="form-control input-pill" id="selectProfileInformation">
                        <option disabled selected value="">Seleccione un tipo de perfil</option>
                        <option value="true">Perfil de programa</option>
                        <option value="false">Perfil de campo comun</option>
                    </select>
                </div>
            </form>
            <ul class="nav nav-pills nav-primary d-none" id="pills-tab" role="tablist">

                @foreach ($facultys as $faculty)
                <li class="nav-item">
                    <a class="nav-link sede-tab" id="pills-home-tab-nobd" data-toggle="pill"
                        href="#pills-horarios-nobd" role="tab" aria-controls="pills-home-nobd" aria-selected="true"
                        data-value="{{ $faculty->id }}">
                        {{ ucfirst(strtolower($faculty->name_faculty)) }}
                    </a>
                </li>
                @endforeach

            </ul>
            <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                <div class="tab-pane fade show active" id="pills-horarios-nobd" role="tabpanel"
                    aria-labelledby="pills-home-tab-nobd">
                    <div id="profileEgressContainer" class="row">
                        <div class="col-12 text-center">
                            <h4>Por favor, selecciona una opción para visualizar los perfiles de egreso disponibles.</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/listProfilesCompetenciesRa.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/listProfilesCompetenciesRa.js') }}"></script>
    <script src="{{ asset('js/functionTables.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection