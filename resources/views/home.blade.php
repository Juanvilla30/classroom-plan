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
                <a href="/home">Inicio</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div class="card">
        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Información de la plataforma de planes de aula</h5>
        </div>
        <div class="card-body">
            <h5 style="font-weight: bold;">Objetivo del Software:</h5>
            <p>
                Desarrollar una plataforma integral y eficiente que permita a los docentes y administradores de la universidad crear, gestionar y monitorear los planes de aula de manera centralizada. Este software debe optimizar la planificación académica, asegurando que los programas de estudio estén alineados con los objetivos de aprendizaje y las competencias requeridas. Debe facilitar la interacción entre los diferentes componentes del proceso educativo, como las evaluaciones, los contenidos, los resultados de aprendizaje y las actividades, permitiendo un seguimiento detallado del progreso de los planes de aula.
            </p>

            <h5 style="font-weight: bold;">Principales funcionalidades:</h5>
            <ul>
                <li>Gestión de perfil de egreso, competencias y resultados de aprendizaje asociados a cada programa.</li>
                <li>Creación, registro y actualización de planes de aula adaptados para cada curso.</li>
                <li>Integración de objetivo general, especificos, temas, evaluaciones y referencias para cada asignatura.</li>
                <li>Seguimiento para el desarrollo de los planes del aula.</li>
                <li>Generación de informes para el desarrollo del proceso académico.</li>
            </ul>
        </div>

    </div>
</div>

@endsection