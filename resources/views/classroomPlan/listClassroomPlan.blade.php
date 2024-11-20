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

    <div class="d-none" id="userId" data-id="{{ auth()->user()->id }}" data-program="{{ auth()->user()->id_program }}" data-role="{{ auth()->user()->id_role }}"></div>

    @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
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
                        <option value="2">Planes de aula programa pregrado</option>
                        <option value="3">Planes de aula programa posgrado</option>
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
    @endif

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

    <!-- Modal Update State -->
    <div class="modal fade" id="modalUpdateState" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Actualizar Estado</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label id="valueClassroomId" class="d-none"></label>
                    <div class="form-group">
                        <label for="selectState">Selección de estado</label>
                        <select class="form-control input-pill" id="selectState">
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-update">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/listClassroomPlan.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/listClassroomPlan.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection