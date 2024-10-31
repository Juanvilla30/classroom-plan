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
            <h5 class="card-title font-weight-bold text-primary">Seleccion de curso</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="pillSelectFaculty">Seleccionar facultad</label>
                    <select class="form-control input-pill" id="pillSelectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
                        @foreach ($facultys as $faculty)
                        <option value="{{ $faculty->id }}">{{ ucfirst(strtolower($faculty->name_faculty)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="pillSelectProgram">Seleccionar programa</label>
                    <select class="form-control input-pill" id="pillSelectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>

                    </select>
                </div>

                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" id="filterCourse">
                    Seleccione el curso
                </button>
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
                <table class="table table-head-bg-primary table-hover" cellspacing="0" width="100%" style="margin-top: 10px;"
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
                        <label for="pillSelectLearning">Seleccionar resultado de aprendizaje</label>
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
                <div style="margin-top: 10px;">
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
                    <textarea class="form-control readonlyCheck" id="textAreaSpecificOne" rows="6"></textarea>
                </div>

                <div style="margin-top: 10px;">
                    <label>Ingrese objetivo especifico #2</label>
                    <textarea class="form-control readonlyCheck" id="textAreaSpecificTwo readonlyCheck" rows="6"></textarea>
                </div>

                <div style="margin-top: 10px;">
                    <label>Ingrese objetivo especifico #3</label>
                    <textarea class="form-control readonlyCheck" id="textAreaSpecificThree readonlyCheck" rows="6"></textarea>
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
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #1
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
                            <textarea class="form-control readonlyCheck" id="textAreaThemeOne" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #2</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeTwo" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #3</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeThree" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #4</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeFour" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #5</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeFive" rows="6"></textarea>
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
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #2
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
                            <textarea class="form-control readonlyCheck" id="textAreaThemeSix" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #7</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeSeven" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #8</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeEight" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #9</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeNine" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #10</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeTen" rows="6"></textarea>
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
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Objetivo especifico #3
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapseThree" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
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
                            <textarea class="form-control readonlyCheck" id="textAreaThemeEleven" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #12</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeTwelve" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #13</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeThirteen" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #14</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeFourteen" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #15</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeFifteen" rows="6"></textarea>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Ingrese tema semana #16</label>
                            <textarea class="form-control readonlyCheck" id="textAreaThemeSixteen" rows="6"></textarea>
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
                    <h5 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Evaluaciones</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right">
                    <button class="btn btn-primary btn-round" id="createEvaluation">Nueva evaluación</button>
                </div>
            </div>
        </div>

        <div class="card-body">

            <from>
                <div class="table-responsive">
                    <table class="table table-head-bg-primary">
                        <thead>
                            <tr>
                                <th scope="col">Seleccionar</th>
                                <th scope="col">Evaluación</th>
                                <th scope="col">Descripción</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($evaluations as $evaluation)
                            <tr>
                                <td>
                                    <input type="checkbox" name="selectItem" value="{{ $evaluation->id }}">
                                </td>
                                <td>{{ $evaluation->name_evaluation }}</td>
                                <td>{{ $evaluation->description ?? 'Sin descripción' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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
                <label for="pillInput">Ingrese la referencia institucional:</label>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control readonlyCheck" id="linkInstitutionalReferences" placeholder="" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="saveInstitutional">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>

                <label for="pillInput">Ingrese la referencia general:</label>
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control readonlyCheck" id="linkGeneralReferences" placeholder="" aria-label="" aria-describedby="basic-addon1">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button" id="saveGeneral">
                                Guardar
                            </button>
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

    <!-- Modal Evaluation -->
    <div class="modal fade bd-example-modal-lg" id="modalNewEvaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalCourse" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
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

    <!-- Scripts -->
    <script src="{{ asset('js/classroomPlan.js') }}"></script>
    <script src="{{ asset('js/functionTables.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection