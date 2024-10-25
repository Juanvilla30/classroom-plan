@extends('layout.layout')

@section('title')

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
            <a href="#">Gestion de documento</a>
        </li>
    </ul>
</div>
<!-- End Breadcumb Header -->

<!-- document -->
<div>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title font-weight-bold text-primary">Previsualización del Documento PDF</h5>

            <!-- Previsualización del PDF -->
            <iframe src="ruta-del-archivo.pdf" width="100%" height="500px" style="border: none;">
                Tu navegador no soporta la visualización de PDFs.
            </iframe>

            <!-- Botones de acciones -->
            <div class="mt-3">
                <!-- Botón para ver en una nueva pestaña -->
                <a href="ruta-del-archivo.pdf" target="_blank" class="btn btn-primary">Ver en pantalla
                    completa</a>

                <!-- Botón para descargar -->
                <a href="ruta-del-archivo.pdf" download class="btn btn-success">Descargar PDF</a>
            </div>
        </div>
        <!-- end document -->
    </div>
</div>

@endsection