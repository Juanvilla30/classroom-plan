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
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Vizualizar plan de aula</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div id="classroomId" data-id="{{ $id }}"></div>

    <!-- Card Info Cuorse -->
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Información de curso</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right">
                    <button class="btn btn-primary btn-round" id="activateUpdate">
                        Activar actualización
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row text-center">
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->learningResult->competence->profileEgres->program->faculty->name_faculty))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->learningResult->competence->profileEgres->program->name_program))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->semester->name_semester))}}</p>
                    </div>
                </div>                
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Codigo de curso:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->course_code))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->name_course))}}</p>
                    </div>
                </div>                
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Nivel de educación:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->educationLevel->name_education_level))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Campo:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->component->studyField->name_study_field))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Componente:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->component->name_component))}}</p>
                    </div>
                </div>                
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p>{{$classroomInfo->courses->credit}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-4 mx-auto">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->courseType->name_course_type))}}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Ccompetence and Ra -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Competencia y resultado de aprendizaje</h5>
        </div>

        <div class="card-body">

            <form id="fromProfileInfo">

            </form>
            <form id="fromProfileUpdate">

            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Objetvive General and especifics -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Ojetivo general y especificos</h5>
        </div>

        <div class="card-body">

            <form id="fromObjetives">

            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Topics #1 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <form id="fromTopicsOne">

            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Topics #2 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <form id="fromTopicsTwo">

            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Topics #2 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <form id="fromTopicsThree">

            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Evaluations -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Evaluaciones</h5>
        </div>

        <div class="card-body">

            <from id="fromEvaluation">

            </from>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card References -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Referencias</h5>
        </div>

        <div class="card-body">

            <form id="fromReference">

            </form>
            <button type="button" class="btn btn-primary btn-lg btn-block saveTemp d-none">Guardar</button>
        </div>
    </div>
    <!-- End Card -->

    <!-- Modal Activate Update -->
    <div class="modal fade" id="modalActivateUpdate" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Advertencia</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas activar el modo edición?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-activate" data-card="1">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Deactivate Update -->
    <div class="modal fade" id="modalDeactivateUpdate" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Advertencia</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Los datos que no han sido guardados se eliminarán. Por favor, asegúrate de guardar la información antes de desactivar.<br><br>

                    ¿Seguro que deseas desactivar el modo edición?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-desactivate" data-card="1">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Confirm -->
    <div class="modal fade" id="modalConfirm" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Advertencia</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas guardar los cambios?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-button" data-card="1">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/classroomPlans.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/viewClassroom.js') }}"></script>
    <!-- End Scripts -->
</div>

@endsection