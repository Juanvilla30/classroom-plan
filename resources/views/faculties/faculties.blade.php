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
            <a href="#">Gestionar perfil defacultades</a>
        </li>
    </ul>
</div>
<!-- End Breadcumb Header -->


<div class="card-body">
    <!-- form -->
    <form action="" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <br>
        <input type="submit" value="import">
    </form>
    <!-- end form -->
</div>


</div>

@endsection