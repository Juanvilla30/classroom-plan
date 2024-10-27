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

    <!-- Card Profile -->
    <div class="card" id="card-1" style="display: block;">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary">Asignación de perfil de egreso</h4>

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
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Perfil de egreso</label>
                    <textarea class="form-control" id="textAreaProfile" rows="8" required></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 10px;"
                    id="confirmationEmptyOne"> 
                    Guardar
                </button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Competencies -->
    <div class="card" id="card-2" style="display:none;">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary">Asignación de competencias</h4>

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia 1</label>
                    <textarea class="form-control" id="textAreaCompetitionOne" rows="6"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia 2</label>
                    <textarea class="form-control" id="textAreaCompetitionTwo" rows="6"></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 10px;"
                    id="confirmationEmptyTwo">
                    Guardar
                </button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card RA #1 -->
    <div class="card" id="card-3" style="display:none;">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Asignación de resultados de aprendizaje</h4>

            <!-- Accordion -->
            <div class="accordion accordion-secondary">
                <div class="card">
                    <div class="card-header" id="headingOne" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Competencia #1
                        </div>
                        <div class="span-mode"></div>
                    </div>

                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordion">
                        <div class="card-body">
                            Aqui va el texto
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #1</label>
                    <textarea class="form-control" id="textAreaRaOne" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #2</label>
                    <textarea class="form-control" id="textAreaRaTwo" rows="8"></textarea>
                </div>
            </form>
            <!-- End Forms -->

            <!-- Forms -->
            <form>
                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 10px;"
                    id="confirmationEmptyThree">
                    Guardar
                </button>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card RA #2 -->
    <div class="card" id="card-4" style="display:none;">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Asignación de resultados de aprendizaje</h4>

            <!-- Accordion -->
            <div class="accordion accordion-secondary">
                <div class="card">
                    <div class="card-header collapsed" id="headingTwo" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        <div class="span-icon" style="color: #2B7FEA;">
                            <div class="flaticon-box-1"></div>
                        </div>
                        <div class="span-title" style="color: #2B7FEA;">
                            Competencia #2
                        </div>
                        <div class="span-mode"></div>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                        <div class="card-body">
                            Aqui va el texto
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Accordion -->

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #3</label>
                    <textarea class="form-control" id="textAreaRaThree" rows="8"></textarea>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #4</label>
                    <textarea class="form-control" id="textAreaRaFour" rows="8"></textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block" style="margin-top: 10px;"
                    id="confirmationEmptyFour">
                    Guardar
                </button>
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