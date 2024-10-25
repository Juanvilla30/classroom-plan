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
                <a href="#">Listado de perfiles de egresos</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Visualizar perfil de egreso</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <!-- Card 1 -->
    <div class="card">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary">Asignación de perfil de egreso</h4>

            <!-- Forms -->
            <form>
                <div class="form-group">
                    <label for="pillSelect">Seleccionar facultad</label>
                    <select class="form-control input-pill" id="pillSelectFaculty">
                        <option disabled selected value="">Seleccione una facultad</option>
                        
                    </select>
                </div>
                <div class="form-group">
                    <label for="pillSelect">Seleccionar programa</label>
                    <select class="form-control input-pill" id="pillSelectProgram">
                        <option disabled selected value="">Seleccione un programa</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Perfil de egreso</label>
                    <textarea class="form-control" id="textAreaProfile" rows="8" required></textarea>
                </div>
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card 1 -->

    <!-- Card 2 -->
    <div class="card">
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
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card 2 -->

    <!-- Card 3 -->
    <div class="card">
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
            </form>
            <!-- End Forms -->

        </div>
    </div>
    <!-- End Card 3 -->

    <!-- Scripts -->
    <script src="{{ asset('js/profileCompetencieRa.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection