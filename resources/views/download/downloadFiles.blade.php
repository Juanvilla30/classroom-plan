@extends('layout.layout')

@section('title', 'User Management')

@section('content')

@if (auth()->user()->id_role !== 4)
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

<div class="d-none" id="userId" data-id="{{ auth()->user()->id }}" data-program="{{ auth()->user()->id_program }}" data-role="{{ auth()->user()->id_role }}"></div>

<div>
    <div class="card">
        <div class="card-body">
            @if (auth()->user()->id_role == 1 || auth()->user()->id_role == 2)
            <div class="form-group">
                <label for="pillSelect">Seleccion de facultad</label>
                <select class="form-control input-pill" id="selectfacultie">
                    <option disabled selected value="">Seleccione una facultad</option>
                    @foreach ($facultieinfo as $facultie)
                    <option value="{{ $facultie->id}}">{{ $facultie->name_faculty }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="pillSelect">Seleccion de programa</label>
                <select class="form-control input-pill" id="selectprogram" disabled>
                    <option disabled selected value="">Seleccione un programa</option>
                </select>
            </div>
            @endif
            <button type="button" class="btn btn-primary btn-lg btn-block d-none" id="btn-excel">Descargar excel</button>
        </div>
    </div>
</div>

<!-- script -->
<script src="{{asset('js/report.js')}}"></script>
<!-- end script -->
</div>

@else
    <div class="alert alert-danger" role="alert">
        No puedes acceder al contenido!
    </div>
@endif

@endsection