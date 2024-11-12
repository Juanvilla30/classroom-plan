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

            <div class="row text-center" id="viewInfoCampoComun">

            </div>
            <div class="row text-center" id="viewInfoPensum">

            </div>
            <div class="row text-center" id="viewInfoSpecializations">

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

    <!-- Card Select Topics #1 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Selección de temas</h5>
        </div>

        <div class="card-body">
            <ul class="nav nav-pills nav-primary nav-pills-no-bd justify-content-center mb-3" id="pills-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link" id="weeks1" data-toggle="pill" href="#fromWeeks1"
                        role="tab" aria-controls="pills-home-nobd" aria-selected="true">Semana 1-5</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="weeks2" data-toggle="pill" href="#fromWeeks2"
                        role="tab" aria-controls="pills-profile-nobd" aria-selected="false">Semana 6-10</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="weeks3" data-toggle="pill" href="#fromWeeks3"
                        role="tab" aria-controls="pills-contact-nobd" aria-selected="false">Semana 11-16</a>
                </li>
            </ul>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info Topics #2 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <div class="tab-content mb-3" id="pills-tabContent">
                <div class="tab-pane fade" id="fromWeeks1" role="tabpanel"
                    aria-labelledby="pills-home-tab-nobd">
                </div>
                <div class="tab-pane fade" id="fromWeeks2" role="tabpanel"
                    aria-labelledby="pills-profile-tab-nobd">
                </div>
                <div class="tab-pane fade" id="fromWeeks3" role="tabpanel"
                    aria-labelledby="pills-contact-tab-nobd">
                </div>
            </div>

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

    <!-- Modal Confirmation -->
    <div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog"
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
                    ¿Deseas guardar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-button" data-card="1">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Scripts -->
    <script src="{{ asset('js/viewClassroom.js') }}"></script>
    <!-- End Scripts -->
</div>

@endsection