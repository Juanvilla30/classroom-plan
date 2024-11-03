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
                <a href="#">Listado de planes de aula</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <!-- Card -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Selección de facultad</h5>
        </div>

        <div class="card-body">
            <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">

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
        </div>
    </div>
    <!-- End Card -->

    <div class="row" id="cardProgram">
    </div>

    <!-- Card -->
    <div class="card d-none" id="card-1">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Listado de planes de aula</h5>
        </div>

        <div class="card-body">

            <div class="mb-3">
                <input type="text" id="searchCourse" class="form-control" placeholder="Buscar por nombre del curso">
            </div>


            <div class="tab-content mt-2 mb-3" id="pills-without-border-tabContent">
                <div class="tab-pane fade show active" id="pills-horarios-nobd" role="tabpanel"
                    aria-labelledby="pills-home-tab-nobd">
                    <div id="viewClassroomPlan" class="row">
                        <div class="col-12 text-center">
                            <h4>Por favor, selecciona una facultad para visualizar los perfiles de egreso disponibles.</h4>
                        </div>
                    </div>

                    <div id="paginationContainer" class="d-flex justify-content-center my-3">
                        <nav aria-label="...">
                            <ul class="pagination mb-0" id="pagination"></ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End Card -->

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/listClassroomPlan.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/listClassroomPlan.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection