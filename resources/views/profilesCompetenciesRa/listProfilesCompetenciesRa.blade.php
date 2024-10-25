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
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <!-- Card -->
    <div class="card">
        <div class="card-body">

            <h4 class="card-title font-weight-bold text-primary" style="margin-bottom: 10px;">Listado de perfil de egresos</h4>

            <!-- Row -->
            <div class="table-responsive">
                <div id="basic-datatables_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="dataTables_length" id="basic-datatables_length"><label>Show <select name="basic-datatables_length" aria-controls="basic-datatables" class="form-control form-control-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> entries</label></div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div id="basic-datatables_filter" class="dataTables_filter"><label>Buscador:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="basic-datatables"></label></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end Row -->

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-head-bg-primary" style="margin-top: 10px;">
                    <thead>
                        <tr>
                            <th scope="col">Facultad</th>
                            <th scope="col">Programa</th>
                            <th scope="col">Perfil de egreso</th>
                            <th scope="col">Competencia 1</th>
                            <th scope="col">Competencia 2</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="detalle-docente" data-docente-id="1">
                                <a href="{{ route('viewProfilesCompetenciesRa') }}" class="text-dark">
                                    Facultad
                                </a>
                            </td>
                            <td class="detalle-docente" data-docente-id="1">
                                <a href="{{ route('viewProfilesCompetenciesRa') }}" class="text-dark">
                                    Programa
                                </a>
                            </td>
                            <td class="detalle-docente" data-docente-id="1">
                                <a href="{{ route('viewProfilesCompetenciesRa') }}" class="text-dark">
                                    Perfil de egreso
                                </a>
                            </td>
                            <td class="detalle-docente" data-docente-id="1">
                                <a href="{{ route('viewProfilesCompetenciesRa') }}" class="text-dark">
                                    Competencias 1
                                </a>
                            </td>
                            <td class="detalle-docente" data-docente-id="1">
                                <a href="{{ route('viewProfilesCompetenciesRa') }}" class="text-dark">
                                    Competencias 2
                                </a>
                            </td>
                            <td>
                                <!-- Botón para editar -->
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#modalEdit">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <!-- Botón para eliminar -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#modalConfirmationDelete">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- End Table -->

            <!-- Pagination -->
            <nav aria-label="Page navigation example">
                <ul class="pagination justify-content-end">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Previous</a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">Next</a>
                    </li>
                </ul>
            </nav>
            <!-- End Pagination -->

        </div>
    </div>
    <!-- End Card -->

    <!-- Modal -->
    <div class="modal fade bd-example-modal-lg" id="modalEdit" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-primary" id="exampleModalLongTitle" style="font-size: 25px; ">Advertencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">Perfil de egreso</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="8"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Competencia 1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Competencia 2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Resultado de aprendizaje #1</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Resultado de aprendizaje #2</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Resultado de aprendizaje #3</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">Resultado de aprendizaje #4</label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
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
    <div class="modal fade" id="modalConfirmationDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="font-size: 25px;">Advertencia</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    ¿Seguro que deseas eliminar?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Aceptar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Modal -->

    <!-- Styles -->
    <link rel="stylesheet" href="../../css/listProfilesCompetenciesRa.css">
    <!-- End Styles -->

    <!-- Scripts -->
    <script src="{{ asset('js/listProfilesCompetenciesRa.js') }}"></script>
    <!-- End Scripts -->

</div>

@endsection