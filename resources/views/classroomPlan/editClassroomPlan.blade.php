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
                <a href="#">Vizualizar plan de aula</a>
            </li>
        </ul>
    </div>
    <!-- End Breadcumb Header -->

    <div id="classroomId" data-id="{{ $id }}"></div>

    <!-- Card Info -->
    <div class="card">

        <div class="card-header">
            <h5 class="card-title font-weight-bold text-primary">Información de curso</h5>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Facultad:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->name_course))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Programa:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->name_course))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Campo:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->component->studyField->name_study_field))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Componente:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->component->name_component))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Curso:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->name_course))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Semestre:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->semester->name_semester))}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Creditos:</label>
                        <p>{{$classroomInfo->courses->credit}}</p>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label>Tipo de curso:</label>
                        <p>{{ucfirst(strtolower($classroomInfo->courses->courseType->name_course_type))}}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- End Card -->

    <!-- Scripts -->
    <script src="{{ asset('js/viewClassroom.js') }}"></script>
    <!-- End Scripts -->
</div>

@endsection