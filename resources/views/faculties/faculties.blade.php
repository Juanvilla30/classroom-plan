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
            <a href="#">Gestionar Plan Aula</a>
        </li>
    </ul>
</div>
<!-- End Breadcumb Header -->

<div id="documentId" data-id="{{ $id}}"></div>

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
                <!-- Botón para descargar excel -->
                <a href="{{ route('export')}}" download class="btn btn-primary">Descargar Excel</a>

                <!-- Botón para descargar -->
                <a href="{{ route('pdfplan')}}" class="btn btn-warning">Descargar PDF</a>
            </div>
        </div>
        <!-- end document -->
    </div>
</div>


</div>

@endsection