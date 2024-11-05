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
                <a href="#">Gestion de plan de aula</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <!-- Card Select-->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="selectEducation">Selección nivel de educación</label>
                    <select class="form-control input-pill" id="selectEducation">
                        <option disabled selected value="">Seleccione un nivel de educación</option>
                        @foreach ($educationInfo as $education)
                        <option value="{{ $education->id }}">{{ ucfirst(strtolower($education->name_education_level)) }}
                        </option>
                        @endforeach
                    </select>
                </div>                
            </form>
            <form id="fromSelectCourse" class="d-none">
                
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card List-->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Listado de curso</h5>
        </div>

        <div class="card-body">

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-head-bg-primary" cellspacing="0" width="100%" style="margin-top: 10px;"
                    id="tableFieldStudy">
                    <thead>
                        <tr>
                            <th scope="col">Campo</th>
                            <th scope="col">Componente</th>
                            <th scope="col">Curso</th>
                            <th scope="col">Semestre</th>
                            <th scope="col">Creditos</th>
                            <th scope="col">Tipo de curso</th>
                        </tr>
                    </thead>
                    <tbody id="bodyComponent">
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Info -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Información de curso</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p id="nameFaculty"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p id="nameProgram"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Campo:</label>
                        <p id="nameField"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Componente:</label>
                        <p id="nameComponent"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p id="nameCourse"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p id="nameSemester"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p id="nameCredits"></p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p id="nameCourseType"></p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card RA -->
    <div class="card" id="card-1" style="display:block;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Resultados de aprendizaje</h5>
        </div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <div class="form-group">
                        <label for="pillSelectLearning">Selección de resultados de aprendizaje</label>
                        <select class="form-control input-pill" id="pillSelectLearning" disabled>
                            <option disabled selected value="">Seleccione un resultado de aprendizaje</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripción</label>
                    <textarea class="form-control" id="textareaDescriptionRA" rows="10" readonly></textarea>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="1">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>
        </div>

    </div>
    <!-- End Card -->

    <!-- Card Objective -->
    <div class="card" id="card-2" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Objetivo general</h5>
        </div>

        <div class="card-body">
            <form>
                <div>
                    <label>Ingrese objetivo general:</label>
                    <textarea class="form-control readonlyCheck" id="textAreaObjective" rows="10" readonly></textarea>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="2">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>

        </div>

    </div>
    <!-- End Card -->

    <!-- Card Specific Objective -->
    <div class="card" id="card-3" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Objetivos especificos</h5>
        </div>

        <div class="card-body">

            <form>
                <div style="margin-top: 10px;">
                    <label>Ingrese objetivo especifico #1</label>
                    <textarea class="form-control readonlyCheck" id="textAreaSpecific1" rows="6"></textarea>
                </div>

                <div style="margin-top: 10px;">
                    <label>Ingrese objetivo especifico #2</label>
                    <textarea class="form-control readonlyCheck" id="textAreaSpecific2" rows="6"></textarea>
                </div>

                <div style="margin-top: 10px;">
                    <label>Ingrese objetivo especifico #3</label>
                    <textarea class="form-control readonlyCheck" id="textAreaSpecific3" rows="6"></textarea>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="3">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none" data-check="1">Siguiente</button>
            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Specific Objective #1 -->
    <div class="card" id="card-4" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <!-- Accordion -->
            <div class="accordion accordion-secondary" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapseOne">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #1
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapse1" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <form>
                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #1</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme1" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #2</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme2" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #3</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme3" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #4</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme4" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #5</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme5" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <!-- End Row -->

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="4">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none" data-check="1">Siguiente</button>
            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Specific Objective #2 -->
    <div class="card" id="card-5" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <!-- Accordion -->
            <div class="accordion accordion-secondary" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse2" aria-expanded="true" aria-controls="collapseTwo">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #2
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapse2" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <form>
                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #6</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme6" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #7</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme7" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #8</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme8" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #9</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme9" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #10</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme10" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <!-- End Row -->

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="5">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none" data-check="1">Siguiente</button>
            </form>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Specific Objective #3 -->
    <div class="card" id="card-6" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Temas</h5>
        </div>

        <div class="card-body">

            <!-- Accordion -->
            <div class="accordion accordion-secondary" style="margin-top: 10px;">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapse3" aria-expanded="true" aria-controls="collapseThree">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #3
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapse3" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <from>
                <!-- Row -->
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #11</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme11" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #12</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme12" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #13</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme13" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #14</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme14" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #15</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme15" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #16</label>
                            <textarea class="form-control readonlyCheck" id="textAreaTheme16" rows="6"></textarea>
                        </div>
                    </div>
                </div>
                <!-- End Row -->

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="6">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </from>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Evaluations -->
    <div class="card" id="card-7" style="display:none;">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Evaluaciones</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right">
                    <button class="btn btn-primary btn-round" id="createEvaluation"
                        data-toggle="modal" data-target="#modalNewEvaluation">
                        Nueva evaluación
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">

            <from>
                <div class="row d-none" id="percentageView">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>
                            <p id="percentage1"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>
                            <p id="percentage2"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 40%</label>
                            <p id="percentage3"></p>
                        </div>
                    </div>
                </div>

                <div class="row " id="percentageContainer">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>

                            <div class="form-group" id="evaluationsCheckbox1">

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>
                            <div class="form-group" id="evaluationsCheckbox2">

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 40%</label>
                            <div class="form-group" id="evaluationsCheckbox3">

                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="7">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </from>

        </div>
    </div>
    <!-- End Card -->

    <!-- Card References -->
    <div class="card" id="card-8" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Referencias</h5>
        </div>

        <div class="card-body">

            <form>
                <div class="table-responsive d-none" id="tableReferent">
                    <table class="table table-head-bg-primary">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Referencias</th>
                                <th scope="col">Links</th>
                            </tr>
                        </thead>
                        <tbody id="bodyReferences">
                        </tbody>
                    </table>
                </div>

                <div class="" id="createReferent">
                    <div class="" id="institutionalContainer">
                        <div class="form-group">
                            <label>Referencias institucionales</label>
                            <p id="institutionalView"></p>
                        </div>
                    </div>

                    <label for="pillInput" style="margin-left: 10px;">Ingrese la referencia institucional:</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control readonlyCheck" id="linkInstitutionalReferences" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-primary referenceLinks" type="button" id="saveInstitutional"
                                    data-links="1">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="" id="generalContainer">
                        <div class="form-group">
                            <label>Referencias generales</label>
                            <p id="generalView"></p>
                        </div>
                    </div>

                    <label for="pillInput" style="margin-left: 10px;">Ingrese la referencia general:</label>
                    <div class="form-group">
                        <div class="input-group">
                            <input type="text" class="form-control readonlyCheck" id="linkGeneralReferences" placeholder="" aria-label="" aria-describedby="basic-addon1">
                            <div class="input-group-append">
                                <button class="btn btn-primary referenceLinks" type="button" id="saveGeneral"
                                    data-links="2">
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="8">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>

        </div>
    </div>
    <!-- End Card -->

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

    <!-- Modal Select Course -->
    <div class="modal fade bd-example-modal-lg" id="modalCourse" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                </div>
                <div class="modal-body">

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-head-bg-primary table-hover" cellspacing="0" width="100%" style="margin-top: 10px;" id="tableCourses">
                            <thead>
                                <tr>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col">Facultad</th>
                                    <th scope="col">Programa</th>
                                    <th scope="col">Campo</th>
                                    <th scope="col">Componente</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Creditos</th>
                                    <th scope="col">Tipo de curso</th>
                                </tr>

                            </thead>
                            <tbody id="bodyCourses">
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table -->

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal List Courses -->
    <div class="modal fade bd-example-modal-lg" id="modalListCourses" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Nueva evaluación</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="pillInput">Ingrese el nombre de la evaluación</label>
                            <input type="text" class="form-control input-pill" id="pillInput" placeholder="Nombre de Evaluación">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Ingrese la descripción</label>
                            <textarea class="form-control" id="exampleFormControlTextarea1" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Modal Evaluation -->
    <div class="modal fade bd-example-modal-lg" id="modalNewEvaluation" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Nueva evaluación</h5>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="pillInput">Ingrese el nombre de la evaluación</label>
                            <input type="text" class="form-control input-pill" id="nameEvaluation" placeholder="Nombre de Evaluación">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Ingrese la descripción</label>
                            <textarea class="form-control" id="descriptionEvaluation" rows="8"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/classroomPlans.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/classroomPlan.js') }}"></script>
    <script src="{{ asset('js/functionTables.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection