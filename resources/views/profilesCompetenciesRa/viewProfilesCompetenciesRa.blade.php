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
                <a href="#">Listado de perfiles de egreso</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Visualizar información de perfil de egresos</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div class="d-none" id="programId" data-info="{{ $programId }}"></div>
    <div class="d-none" id="profileId" data-id="{{ $id }}"></div>

    <!-- Card Profile -->
    <div class="card">

        <div class="card-header">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <h5 class="card-title font-weight-bold text-primary">Visualizar información de perfil de egresos</h5>
                </div>
                <div class="col-sm-12 col-md-6 text-md-right">
                    <button class="btn btn-primary btn-round" id="activateUpdate">
                        Activar actualización
                    </button>
                </div>
            </div>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="row" id="viewInfo">

                </div>
            </form>
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Perfil de egreso</label>
                    <textarea class="form-control" id="textAreaProfile" rows="10" readonly>{{ ucfirst(strtolower($profileEgress->description_profile_egres)) }}</textarea>
                </div>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Competencie #1 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Competencia y resultados de aprendizaje</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia #1</label>
                    <textarea class="form-control" id="textAreaCompeOne" rows="10" readonly>@php $competencia1 = $competences->firstWhere('name_competence', 'Competencias #1');@endphp @if($competencia1){{ ucfirst(strtolower($competencia1->description_competence)) }}@else
                        No hay descripción disponible para esta competencia.
                    @endif
                    </textarea>
                </div>
                @php
                // Asegúrate de que $competencia1 no sea nulo y que su id exista en $learningResults
                $rA1 = isset($competencia1) && isset($learningResults[$competencia1->id])
                ? $learningResults[$competencia1->id]->firstWhere('name_learning_result', 'Resultados de aprendizaje #1')
                : null;
                @endphp
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #1</label>
                    <textarea class="form-control" id="textAreaRaOne" rows="8" readonly>@if($rA1){{ ucfirst(strtolower($rA1->description_learning_result)) }}@else
                        No hay descripción disponible para este resultado de aprendizaje.
                    @endif
                    </textarea>
                </div>
                @php
                // Asegúrate de que $competencia1 no sea nulo y que su id exista en $learningResults
                $rA2 = isset($competencia1) && isset($learningResults[$competencia1->id])
                ? $learningResults[$competencia1->id]->firstWhere('name_learning_result', 'Resultados de aprendizaje #2')
                : null;
                @endphp
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #2</label>
                    <textarea class="form-control" id="textAreaRaTwo" rows="8" readonly>@if($rA2){{ ucfirst(strtolower($rA2->description_learning_result)) }}@else
                        No hay descripción disponible para este resultado de aprendizaje.
                    @endif
                    </textarea>
                </div>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Card Competencie #2 -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Competencia y resultados de aprendizaje</h5>
        </div>

        <div class="card-body">

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Competencia #2</label>
                    <textarea class="form-control" id="textAreaCompeTwo" rows="10" readonly>@php $competencia1 = $competences->firstWhere('name_competence', 'Competencias #2');@endphp @if($competencia1) {{ ucfirst(strtolower($competencia1->description_competence)) }} @else 
                        No hay descripción disponible para esta competencia.
                    @endif
                    </textarea>
                </div>
                @php
                // Asegúrate de que $competencia1 no sea nulo y que su id exista en $learningResults
                $rA3 = isset($competencia1) && isset($learningResults[$competencia1->id])
                ? $learningResults[$competencia1->id]->firstWhere('name_learning_result', 'Resultados de aprendizaje #3')
                : null;
                @endphp
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #3</label>
                    <textarea class="form-control" id="textAreaRaThree" rows="8" readonly>@if($rA3){{ ucfirst(strtolower($rA3->description_learning_result)) }}@else
                        No hay descripción disponible para este resultado de aprendizaje.
                    @endif
                    </textarea>
                </div>
                @php
                // Asegúrate de que $competencia1 no sea nulo y que su id exista en $learningResults
                $rA4 = isset($competencia1) && isset($learningResults[$competencia1->id])
                ? $learningResults[$competencia1->id]->firstWhere('name_learning_result', 'Resultados de aprendizaje #4')
                : null;
                @endphp
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Resultado de aprendizaje #4</label>
                    <textarea class="form-control" id="textAreaRaFour" rows="8" readonly>@if($rA4){{ ucfirst(strtolower($rA4->description_learning_result)) }}@else
                        No hay descripción disponible para este resultado de aprendizaje.
                    @endif
                    </textarea>
                </div>
                <button type="button" class="btn btn-primary btn-lg btn-block d-none" id="saveUpdateProfile">Guardar</button>
            </form>
            <!-- End Forms -->

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

    <!-- Scripts -->
    <script src="{{ asset('js/viewProfiles.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection