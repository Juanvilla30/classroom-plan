<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {
        return view('home');
        // Lógica para mostrar una lista de elementos
    }
}
