@extends('layout.layout')

@section('title', 'User Management')

@section('content')

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
                                <a href="{{ route('ListUsers')}}" class="text-dark">
                                    {{ $loop->iteration }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="{{ route('ListUsers')}}" class="text-dark">
                                    {{ $user->name }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="{{ route('ListUsers')}}" class="text-dark">
                                    {{ $user->last_name }}
                                </a>
                            </td>
                            <td class="detalle-user" data-user-id="{{ $user->id }}">
                                <a href="{{ route('ListUsers')}}" class="text-dark">
                                    {{ $user->email }}
                                </a>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                    data-target="#ModalUpdate" onclick="reloadModal({{ $user->id }})" id="btnmodal-update">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                    data-target="#exampleModalCenter" onclick="setUserId({{ $user->id}})">
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

        <!-- Modal -->
        <form method="POST" action="/user" id="userForm">
            @csrf
            <div class="modal fade" id="addRowModal" tabindex="-1" role="dialog" style="display: none;"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header no-bd">
                            <h5 class="modal-title">
                                <span class="fw-mediumbold">Nuevo</span>
                                <span class="fw-light">Usuario</span>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="small">Crea una nueva fila usando este formulario, asegúrate de completarlos
                                todos.</p>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Nombres</label>
                                        <input id="addName" type="text" class="form-control" placeholder="Nombres"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Apellidos</label>
                                        <input id="addLastName" type="text" class="form-control" placeholder="Apellidos"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Teléfono</label>
                                        <input id="addPhone" type="text" class="form-control" placeholder="Teléfono"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Correo</label>
                                        <input id="addEmail" type="email" class="form-control" placeholder="Correo"
                                            required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Contraseña</label>
                                        <input id="addPassword" type="password" class="form-control"
                                            placeholder="Contraseña" required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group form-group-default">
                                        <label>Rol</label>
                                        <select id="addRole" class="form-control" required>
                                            @foreach($roles as $rol)
                                            <option value="{{$rol->id}}">{{$rol->name_role}}</option>
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
                    <div class="modal-header no-bd">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold">Actualizar</span>
                            <span class="fw-light">Usuario</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
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
                                        <input id="updatePhone" type="text" class="form-control" placeholder="Teléfono"
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
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer no-bd">
                        <input type="hidden" id="userId">
                        <button type="button" class="btn btn-primary" id="btn-update"
                            id="btn-update" data-user-id="{{$user->id}}">Actualizar</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- end modal update -->

        <!-- Modal eliminate -->
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Eliminar</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">¿Desea eliminar este usuario?
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

@endsection