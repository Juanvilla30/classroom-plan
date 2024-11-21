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

    <div class="d-none" id="userId" data-id="{{ json_encode(auth()->user()) }}"></div>

    @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
    <!-- Card Select-->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="selectTypeClassroom">Selección tipo de plan de aula</label>
                    <select class="form-control input-pill selectsFrom" id="selectTypeClassroom">
                        <option disabled selected value="">Seleccione un tipo de plan de aula</option>
                        <option value="1">Planes de aula campo comun</option>
                        <option value="2">Planes de aula programas de pregrado</option>
                        <option value="3">Planes de aula programas de posgrados</option>
                    </select>
                </div>
                <div class="form-group d-none" id="fromSelectFaculty">
                    <label for="selectFaculty">Selección facultad</label>
                    <select class="form-control input-pill selectsFrom" id="selectFaculty" disabled>
                        <option disabled selected value="">Seleccione una facultad</option>
                        @foreach ($facultyInfo as $faculty)
                        <option value="{{ $faculty->id }}">{{ ucfirst(strtolower($faculty->name_faculty)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-none" id="fromSelectProgram">
                    <label for="selectProgram">Selección programa</label>
                    <select class="form-control input-pill selectsFrom" id="selectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>
                    </select>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block d-none" style="margin-top: 20px;" id="buttonSearchCourse">
                    Seleccione el curso
                </button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->
    @endif

    @if (auth()->user()->id_role == 3 || auth()->user()->id_role == 4)
    <!-- Card Select-->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>
        </div>

        <div class="card-body">
            <!-- Forms -->
            <form>
                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 20px;" id="searchCourseBtn">
                    Seleccione el curso
                </button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->
    @endif

    <!-- Card Info -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Información de curso</h5>
        </div>

        <div class="card-body">

            <form>
                <div class="row text-center" id="infoPensum">
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Facultad:</label>
                            <p id="nameFaculty"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Programa:</label>
                            <p id="nameProgram"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Semestre:</label>
                            <p id="nameSemester"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Codigo de Curso:</label>
                            <p id="codeCourse"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Curso:</label>
                            <p id="nameCourse"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Nivel de educación:</label>
                            <p id="educationLevel"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Campo:</label>
                            <p id="nameField"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Componente:</label>
                            <p id="nameComponent"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Creditos:</label>
                            <p id="nameCredits"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Tipo de curso:</label>
                            <p id="nameCourseType"></p>
                        </div>
                    </div>
                </div>
                <div class="row text-center d-none" id="infoCampoComun">
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Codigo de Curso:</label>
                            <p id="codeCourseCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Curso:</label>
                            <p id="nameCourseCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Nivel de educación:</label>
                            <p id="educationLevelCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Campo:</label>
                            <p id="nameFieldCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Componente:</label>
                            <p id="nameComponentCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Creditos:</label>
                            <p id="nameCreditsCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Semestre:</label>
                            <p id="nameSemesterCC"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Tipo de curso:</label>
                            <p id="nameCourseTypeCC"></p>
                        </div>
                    </div>
                </div>
                <div class="row text-center d-none" id="infoSpecialization">
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Facultad:</label>
                            <p id="nameFacultyS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Programa:</label>
                            <p id="nameProgramS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Semestre:</label>
                            <p id="nameSemesterS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Codigo de Curso:</label>
                            <p id="codeCourseS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Curso:</label>
                            <p id="nameCourseS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Nivel de educación:</label>
                            <p id="educationLevelS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Creditos:</label>
                            <p id="nameCreditsS"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4 mx-auto">
                        <div class="form-group">
                            <label>Tipo de curso:</label>
                            <p id="nameCourseTypeS"></p>
                        </div>
                    </div>
                </div>
            </form>

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
                <table class="table table-head-bg-primary" cellspacing="0" width="100%"
                    style="margin-top: 10px;" id="tableFieldStudy">
                    <thead>
                        <tr>
                            <th scope="col">Campo</th>
                            <th scope="col">Componente</th>
                            <th scope="col">Codigo de curso</th>
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

    <!-- Card RA -->
    <div class="card" id="card-1" style="display:block;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Resultados de aprendizaje</h5>
        </div>

        <div class="card-body">
            <form>
                <div class="form-group">
                    <div class="form-group">
                        <label for="selectLearning">Selección de resultados de aprendizaje</label>
                        <select class="form-control input-pill" id="selectLearning" disabled>
                            <option disabled selected value="">Seleccione un resultado de aprendizaje</option>

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Descripción</label>
                    <textarea class="form-control" id="textAreaDescriptionRA" rows="10" readonly></textarea>
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
            <h5 class="card-title font-weight-bold text-primary">Evaluaciones</h5>
        </div>

        <div class="card-body">
            <from>
                <div class="row">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>
                            <p class="percentage" id="percentage1"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 30%</label>
                            <p class="percentage" id="percentage2"></p>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group text-center">
                            <label>PORCENTAJE 40%</label>
                            <p class="percentage" id="percentage3"></p>
                        </div>
                    </div>
                </div>
                <div class="row d-none" id="viewSelectEvaluation">
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="selectProgram">Selección de evaluaciones</label>
                            <select class="form-control input-pill selectEvaluation" data-select-evaluation="1" id="selectEvaluation1">
                                <option disabled selected value="">Seleccione una evaluación</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pillInput" style="margin-left: 10px;">Ingrese el prorcentaje:</label>
                            <div class="input-group">
                                <input type="number" max="30" class="form-control input-pill readonlyCheck" id="inputPercentage1" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-round saveEvaluation" data-evaluation="1" type="button" id="savePercentage1"
                                        data-links="1">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="selectProgram">Selección de evaluaciones</label>
                            <select class="form-control input-pill selectEvaluation" data-select-evaluation="2" id="selectEvaluation2">
                                <option disabled selected value="">Seleccione una evaluación</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pillInput" style="margin-left: 10px;">Ingrese el prorcentaje:</label>
                            <div class="input-group">
                                <input type="number" max="30" class="form-control input-pill readonlyCheck" id="inputPercentage2" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-round saveEvaluation" data-evaluation="2" type="button" id="savePercentage2"
                                        data-links="2">
                                        Guardar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-4">
                        <div class="form-group">
                            <label for="selectProgram">Selección de evaluaciones</label>
                            <select class="form-control input-pill selectEvaluation" data-select-evaluation="3" id="selectEvaluation3">
                                <option disabled selected value="">Seleccione una evaluación</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pillInput" style="margin-left: 10px;">Ingrese el prorcentaje:</label>
                            <div class="input-group">
                                <input type="number" max="40" class="form-control input-pill readonlyCheck" id="inputPercentage3" placeholder="" aria-label="" aria-describedby="basic-addon1">
                                <div class="input-group-append">
                                    <button class="btn btn-primary btn-round saveEvaluation" data-evaluation="3" type="button" id="savePercentage3"
                                        data-links="3">
                                        Guardar
                                    </button>
                                </div>
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
                <div class="table-responsive" id="tableReferent">
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

                <div class="d-none" id="createReferent">
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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <!-- Table Specialization -->
                    <div class="table-responsive d-none" id="specializationContainer">
                        <table class="table table-head-bg-primary" cellspacing="0" width="100%"
                            style="margin-top: 10px;" id="tableSpecialization">
                            <thead>
                                <tr>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col">Facultad</th>
                                    <th scope="col">Programa</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Créditos</th>
                                    <th scope="col">Tipo de curso</th>
                                </tr>
                            </thead>
                            <tbody id="bodySpecialization">
                            </tbody>
                        </table>
                    </div>

                    <!-- Table Pensum -->
                    <div class="table-responsive d-none" id="pensumContainer">
                        <table class="table table-head-bg-primary" cellspacing="0"
                            width="100%" style="margin-top: 10px;" id="tablePensum">
                            <thead>
                                <tr>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col">Facultad</th>
                                    <th scope="col">Programa</th>
                                    <th scope="col">Campo</th>
                                    <th scope="col">Componente</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Créditos</th>
                                    <th scope="col">Tipo de curso</th>
                                </tr>
                            </thead>
                            <tbody id="bodyPensum">
                            </tbody>
                        </table>
                    </div>

                    <!-- Table CampoComun -->
                    <div class="table-responsive d-none" id="campoComunContainer">
                        <table class="table table-head-bg-primary" cellspacing="0" width="100%"
                            style="margin-top: 10px;" id="tableCampoComun">
                            <thead>
                                <tr>
                                    <th scope="col">Seleccionar</th>
                                    <th scope="col">Campo</th>
                                    <th scope="col">Componente</th>
                                    <th scope="col">Curso</th>
                                    <th scope="col">Semestre</th>
                                    <th scope="col">Créditos</th>
                                    <th scope="col">Tipo de curso</th>
                                </tr>
                            </thead>
                            <tbody id="bodyCampoComun">
                            </tbody>
                        </table>
                    </div>

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
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" style="max-width: 90%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="card-title font-weight-bold text-primary">Selección de curso</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Resultado de aprendizaje</label>
                            <textarea class="form-control" id="textAreaDescriptionLearning" rows="6" disabled></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">Objetivo general</label>
                            <textarea class="form-control unlockFields" id="textAreaDescriptionGeneral" rows="8" disabled></textarea>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-md-4 mx-auto">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Objetivo especifico #1</label>
                                        <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific1" rows="6" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mx-auto">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Objetivo especifico #1</label>
                                        <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific2" rows="6" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-4 mx-auto">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Objetivo especifico #1</label>
                                        <textarea class="form-control unlockFields" id="textAreaDescriptionSpecific3" rows="6" disabled></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
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
                        <div class="table-responsive" id="tableEvaluation">
                            <table class="table table-head-bg-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">Evaluación</th>
                                        <th scope="col">Porcenteje</th>
                                        <th scope="col">Nombre porcenteje</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyEvaluation2">
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" id="tableReferences">
                            <table class="table table-head-bg-primary">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Referencia</th>
                                        <th scope="col">Links</th>
                                    </tr>
                                </thead>
                                <tbody id="bodyReferences2">
                                </tbody>
                            </table>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
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
    <!-- End Scripts -->

</div>

@endsection