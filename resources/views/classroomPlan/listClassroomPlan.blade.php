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
            <form>
                <div class="form-group">
                    <label for="selectTypeClassroom">Selección tipo de plan de aula</label>
                    <select class="form-control input-pill" id="selectTypeClassroom">
                        <option disabled selected value="">Seleccione un tipo de plan de aula</option>
                        <option value="1">Planes de aula campo comun</option>
                        <option value="2">Planes de aula pensum</option>
                        <option value="3">Planes de aula especializaciones</option>
                    </select>
                </div>
                <div class="form-group d-none" id="selectFacultyInfo">
                    <label for="selectFaculty">Selección facultad</label>
                    <select class="form-control input-pill" id="selectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
                    </select>
                </div>
                <div class="form-group d-none" id="selectProgramInfo">
                    <label for="selectProgram">Selección programa</label>
                    <select class="form-control input-pill" id="selectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>
                    </select>
                </div>
            </form>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="card d-none" id="card-1">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Listado de plan de aula</h5>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-head-bg-primary table-hover" id="tableClassroom">
                    <thead>
                        <tr>
                            <th scope="col">Campo</th>
                            <th scope="col">Componente</th>
                            <th scope="col">Codigo de curso</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Semestre</th>
                            <th scope="col">Creditos</th>
                            <th scope="col">Tipo de curso</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="bodyTableClassroom">
                    </tbody>
                </table>
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