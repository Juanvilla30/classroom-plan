<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacultiController extends Controller
{
    public function index(){
        return view("faculties.faculties");
    }

    public function import(Request $request){
        dd("se importo el archivo");
    }
}
