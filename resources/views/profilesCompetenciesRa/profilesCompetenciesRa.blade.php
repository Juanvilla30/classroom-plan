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
                <a href="#">Gestionar perfil de egreso</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div class="d-none" id="userId" data-id="{{ auth()->user()->id }}" data-program="{{ auth()->user()->id_program }}" data-role="{{ auth()->user()->id_role }}"></div>

    <!-- Card Profile -->
    <div class="card" id="card-1" style="display: block;">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Asignación de perfil de egreso</h5>
                </div>
                @if (auth()->user()->id_role == 3)
                <div class="col-sm-12 col-md-6 text-md-right d-none" id="btnActivateUpdate">
                    <button class="btn btn-primary btn-round" id="activateUpdate">
                        Vizualización
                    </button>
                </div>
                @endif
            </div>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
                <div class="form-group">
                    <label for="selectProfileInformation">Seleccionar el tipo de perfil</label>
                    <select class="form-control input-pill" id="selectProfileInformation">
                        <option disabled selected value="">Seleccione un tipo de perfil</option>
                        <option value="true">Perfil de programa</option>
                        <option value="false">Perfil de campo comun</option>
                    </select>
                </div>
            </form>
            <form>
                <div class="form-group d-none" id="showFaculty">
                    <label for="pillSelectFaculty">Seleccionar facultad</label>
                    <select class="form-control input-pill" id="pillSelectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
                        @foreach ($facultys as $faculty)
                        <option value="{{ $faculty->id }}">{{ ucfirst(strtolower($faculty->name_faculty)) }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group d-none" id="showProgram">
                    <label for="pillSelectProgram">Seleccionar programa</label>
                    <select class="form-control input-pill" id="pillSelectProgram" disabled>
                        <option disabled selected value="">Seleccione un programa</option>

                    </select>
                </div>
                @endif

                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Perfil de egreso</label>
                    <textarea class="form-control readonlyField" id="textAreaProfile" rows="8" readonly></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="1">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Competencies -->
    <div class="card" id="card-2" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Asignación de competencias</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia 1</label>
                    <textarea class="form-control readonlyField" id="textAreaCompetitionOne" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia 2</label>
                    <textarea class="form-control readonlyField" id="textAreaCompetitionTwo" rows="6"></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="2">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card RA #1 -->
    <div class="card" id="card-3" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Asignación de resultados de aprendizaje</h5>
        </div>

        <div class="card-body">

            <!-- Accordion -->
            <div class="accordion accordion-secondary">
                <div class="card">
                    <div class="card-header" id="contentCompetitionOne" data-toggle="collapse" data-target="#contCompeOne" aria-expanded="true" aria-controls="contCompeOne">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Competencia #1
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="contCompeOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #1</label>
                    <textarea class="form-control readonlyField" id="textAreaRaOne" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #2</label>
                    <textarea class="form-control readonlyField" id="textAreaRaTwo" rows="8"></textarea>
                </div>
            </form>
            <!-- End Forms -->

            <!-- Forms -->
            <form>
                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="3">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card RA #2 -->
    <div class="card" id="card-4" style="display:none;">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Asignación de resultados de aprendizaje</h5>
        </div>

        <div class="card-body">

            <!-- Accordion -->
            <div class="accordion accordion-secondary">
                <div class="card">
                    <div class="card-header collapsed" id="headingTwo" data-toggle="collapse" data-target="#contCompeTwo" aria-expanded="false" aria-controls="contCompeTwo">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Competencia #2
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="contCompeTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">

                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #3</label>
                    <textarea class="form-control readonlyField" id="textAreaRaThree" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #4</label>
                    <textarea class="form-control readonlyField" id="textAreaRaFour" rows="8"></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block confirmationSave d-none" style="margin-top: 10px;"
                    data-confirmation="4">
                    Guardar
                </button>
                <button type="button" class="btn btn-primary btn-lg btn-block nextCard d-none">Siguiente</button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Modal -->
    <div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 25px;">Advertencia</h5>
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
    <script src="{{ asset('js/profileCompetencieRa.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection