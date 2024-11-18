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
                <div class="col-sm-12 col-md-6 text-md-right d-none" id="btnActivateUpdate">
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

    <!-- Card Competence -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Competencias y resultados de aprendizaje</h5>
        </div>

        <div class="card-body">
            <form id="viewDataProfile">
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" id="labelNameCompetence"></label>
                    <textarea class="form-control" id="textAreaDescriptionCompetence" rows="6" disabled></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" id="labelNameLearning"></label>
                    <textarea class="form-control" id="textAreaDescriptionLearning" rows="6" disabled></textarea>
                </div>
            </form>

            <form class="d-none" id="viewDataUpdate">
                <div class="form-group">
                    <label for="selectLearning">Seleccción de resultado de aprendizaje</label>
                    <select class="form-control input-pill" id="selectLearning">
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripción:</label>
                    <textarea class="form-control" id="textAreaSelectLearning" rows="6" disabled></textarea>
                </div>
            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Objetives -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Objetivo general y especificos</h5>
        </div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1" id="labelNameGeneral"></label>
                    <textarea class="form-control unlockFields" id="textAreaDescriptionGeneral" rows="8" disabled></textarea>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" id="labelSpecific1"></label>
                                <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific1" rows="6" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" id="labelSpecific2"></label>
                                <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific2" rows="6" disabled></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1" id="labelSpecific3"></label>
                                <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific3" rows="6" disabled></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card Topics -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
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

    <!-- Card Evaluation -->
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Evaluaciones</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right d-none" id="btnNewEvaluation">
                    <button class="btn btn-primary btn-round ml-auto mb-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form>
                <div class="table-responsive" id="tableEvaluation">
                    <table class="table table-head-bg-primary">
                        <thead>
                            <tr>
                                <th scope="col">Evaluación</th>
                                <th scope="col">Porcenteje</th>
                                <th scope="col">Nombre porcenteje</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="bodyEvaluation">
                        </tbody>
                    </table>
                </div>
            </form>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Referencias</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right d-none" id="btnNewReference">
                    <button class="btn btn-primary btn-round ml-auto mb-3">
                        <i class="fa fa-plus"></i>
                        Agregar
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form>
                <div class="table-responsive" id="tableReferences">
                    <table class="table table-head-bg-primary">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Referencia</th>
                                <th scope="col">Links</th>
                                <th scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="bodyReferences">
                        </tbody>
                    </table>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block d-none" id="btnSaveUpdate">Guardar</button>
            </form>
        </div>
    </div>
    <!-- End Card -->

    <!-- Card -->
    <div class="card d-none" id="card-send">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Enviar</h5>
        </div>

        <div class="card-body">
            <button type="button" class="btn btn-primary btn-lg btn-block" id="btnSendClassroom">Enviar</button>
        </div>
    </div>
    <!-- End Card -->

    <!-- Modal Confirmation -->
    <div class="modal fade" id="modalConfirmationSend" tabindex="-1" role="dialog"
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
                    Recuerda que al enviar el plan de aula, no podrás modificar los registros hasta que se vuelva a autorizar. Asegúrate de que toda la información esté correcta.<br><br>
                    ¿Estás seguro de que deseas actualizar el plan de aula?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-send">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Confirmation -->
    <div class="modal fade" id="modalConfirmationDelete" tabindex="-1" role="dialog"
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
                    ¿Estás seguro de que deseas eliminar el contenido?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-delete">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

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
                    ¿Estás seguro de que deseas actualizar el plan de aula?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-save">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Update Evaluation -->
    <div class="modal fade" id="modalUpdateEvaluation" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Actualizar evaluación</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group" style="text-align: center;">
                            <label id="namePercentage">Porcentaje</label>
                        </div>
                        <div class="form-group">
                            <label for="selectUpdateEvaluation">Selección de evaluaciones</label>
                            <select class="form-control input-pill" id="selectUpdateEvaluation">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pillInput" style="margin-left: 10px;">Ingrese el prorcentaje:</label>
                            <div class="input-group">
                                <input type="number" max="30" class="form-control input-pill" id="inputPercentage"
                                    placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-update-evaluation">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal New Evaluation -->
    <div class="modal fade" id="modalNewEvaluation" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Agregar Evaluación</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="selectUpdateEvaluation">Selección de porcenteje</label>
                            <select class="form-control input-pill" id="selectNewPercentage">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="selectUpdateEvaluation">Selección de evaluaciones</label>
                            <select class="form-control input-pill" id="selectNewEvaluation">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pillInput" style="margin-left: 10px;">Ingrese el prorcentaje:</label>
                            <div class="input-group">
                                <input type="number" max="30" class="form-control input-pill" id="inputNewPercentage"
                                    placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-new-evaluation">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Update References -->
    <div class="modal fade" id="modalUpdateReferences" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Actualizar Referencias</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group" style="text-align: center;">
                        <label id="nameReference"></label>
                    </div>
                    <div class="form-group">
                        <label for="pillInput" style="margin-left: 10px;">Ingrese la referencia:</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="linksContent" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-update-reference">Actualizar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal New References -->
    <div class="modal fade" id="modalNewReferences" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Agregar Referencias</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="selectProgram">Selección de tipo de referencia</label>
                        <select class="form-control input-pill" id="selectNewReference">
                            <option disabled selected value="">Seleccione una tipo de referencia</option>
                            <option value="referencia general">Referencia general</option>
                            <option value="referencia institucional">Referencia institucional</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pillInput" style="margin-left: 10px;">Ingrese la referencia institucional:</label>
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" id="linksNewContent" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="confirm-new-reference">Guardar</button>
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