@extends('layout.layout')

@section('title', 'User Details')

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
    <div class="card-body">
        <div class="container">
            <h2>Información del Usuario</h2>
            <div class="form-group">
                <label for="facultad">Facultad</label>
                <input type="text" class="form-control" id="facultad" value="Ingenieria" disabled>
            </div>
            <div class="form-group">
                <label for="nombre">Nombre del Docente</label>
                <input type="text" class="form-control" id="nombre" value="Carlos Santos" disabled>
            </div>
            <div class="form-group">
                <label for="programa">Programa</label>
                <input type="text" class="form-control" id="programa" value="Ingenieria de software" disabled>
            </div>
            <div class="form-group">
                <label for="usuario">Usuario</label>
                <input type="text" class="form-control" id="usuario" value="Carlos" disabled>
            </div>
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo" value="carlos.s@uniautonoma.edu.co" disabled>
            </div>
        </div>
    </div>
</div>
@endsection