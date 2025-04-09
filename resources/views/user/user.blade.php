@extends('layout.layout')

@section('title', 'User Management')

@section('content')

@if (auth()->user()->id_role == 1)
<meta name="csrf-token" content="{{ csrf_token() }}">

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
            <a href="#">Gestionar perfil de usuario</a>
        </li>
    </ul>
</div>
<!-- End Breadcumb Header -->

<div class="card">
    <!-- Card add row -->
    <div class="card-header">
        <div class="d-flex align-items-center">
            <h4 class="card-title font-weight-bold text-primary">Agregar Usuario</h4>
            <button class="btn btn-primary btn-round ml-auto" data-toggle="modal" data-target="#addRowModal">
                <i class="fa fa-plus"></i>
                Agregar
            </button>
        </div>
    </div>
    <!-- end Card add row -->

    <div class="card-body">
        <!-- User Management Table -->
        <div class="table table-head-bg-primary">
            <div class="table-responsive">
                <table class="display table table-striped table-hover" id="multi-filter-select">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Apellido</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="#" class="text-dark">
                                    {{ $loop->iteration }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="#" class="text-dark">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="#" class="text-dark">
                                    {{ $user->last_name }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="#" class="text-dark">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <button id="btn_update" type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#ModalUpdate" id="btnmodal-update" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button id="btn_delete" type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#modalDelete" data-user-id="{{ $user->id }}">
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <!-- End of User Management Table -->

        <!-- Agrega esto en tu sección <head> para cargar Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

        <!-- Modal create -->
        <form method="POST" action="/user" id="userForm">
            @csrf
            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" style="display: none;"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="card-title font-weight-bold text-primary">Nuevo usuario</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Asegúrate de completarlos todos los campos correctamente.
                            </p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Nombres</label>
                                        <input id="addName" type="text" class="form-control" placeholder="Nombres"
                                            required maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Apellidos</label>
                                        <input id="addLastName" type="text" class="form-control" placeholder="Apellidos"
                                            required maxlength="50">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Teléfono</label>
                                        <input id="addPhone" type="number" class="form-control" placeholder="Teléfono"
                                            required maxlength="10" oninput="this.value=this.value.slice(0,10)">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Correo</label>
                                        <input id="addEmail" type="email" class="form-control" placeholder="Correo"
                                            required maxlength="80">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Contraseña</label>
                                        <input id="addPassword" type="password" class="form-control"
                                            placeholder="Contraseña" required maxlength="10">
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Rol</label>
                                        <select id="addRole" class="form-control" required>
                                            <option disabled selected value="">Seleccione un rol</option>
                                            @foreach($roles as $rol)
                                            @if($rol->id != 1)
                                            <option value="{{ $rol->id }}">{{ ucfirst(strtolower($rol->name_role)) }}</option>
                                            @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div id="programShow" class="form-group form-group-default d-none">
                                        <label>Programa</label>
                                        <select id="selectProgram" class="form-control" required>
                                            <option disabled selected value="">Seleccione un programa</option>
                                            @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ ucfirst(strtolower($program->name_program)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer no-bd">
                            <button type="button" id="addRowButton" class="btn btn-primary">Agregar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <!-- end Modal -->

        <!-- modal update -->
        <div class="modal fade" id="ModalUpdate" tabindex="-1" role="dialog" style="display: none;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="card-title font-weight-bold text-primary">Actualizar usuario</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="small">Actualiza una fila usando este formulario, asegúrate de completarlos todos.
                        </p>
                        <form>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Nombres</label>
                                        <input id="updateName" type="text" class="form-control" placeholder="Nombres"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Apellidos</label>
                                        <input id="updateLastName" type="text" class="form-control"
                                            placeholder="Apellidos" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Teléfono</label>
                                        <input id="updatePhone" type="number" class="form-control" placeholder="Teléfono"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Correo</label>
                                        <input id="updateEmail" type="email" class="form-control" placeholder="Correo"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Contraseña</label>
                                        <input id="updatePassword" type="password" class="form-control"
                                            placeholder="Contraseña" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Rol</label>
                                        <select id="updateRole" class="form-control" required>
                                            @foreach ($roles as $rol)
                                            <option value="{{ $rol->id }}">{{ $rol->name_role }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div id="programShowUpdate" class="form-group form-group-default d-none">
                                        <label>Programa</label>
                                        <select id="updateProgram" class="form-control" required>
                                            <option disabled selected value="">Seleccione un programa</option>
                                            @foreach($programs as $program)
                                            <option value="{{ $program->id }}">{{ ucfirst(strtolower($program->name_program)) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer no-bd">
                        <input type="hidden" id="userId">
                        <button type="button" class="btn btn-primary" id="btnUpdate"
                            data-user-id="{{$user->id}}">Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal update -->

        <!-- Modal eliminate -->
        <div class="modal fade" id="modalDelete" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="card-title font-weight-bold text-primary">Eliminar usuario</h5>

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">¿Seguro que desea eliminar este usuario?
                        <input type="hidden" id="idEliminar" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal"
                            id="btnDelete">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal eliminate -->
    </div>

    <!-- scripts -->
    <script src="{{  asset('js/users.js') }}"></script>
    <script src="{{  asset('js/functionTables.js') }}"></script>
    <!-- end scripts -->
</div>
@else
<div class="alert alert-danger" role="alert">
    No puedes acceder al contenido!
</div>
@endif
@endsection