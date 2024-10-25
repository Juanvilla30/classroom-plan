<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GenerateDocumentController extends Controller
{
    //Metodo para manejar peticiones GET
    public function index()
    {
        return view('document.document');
    }
}
