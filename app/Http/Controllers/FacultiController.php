<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FacultyImport;

class FacultiController extends Controller
{
    public function index(){
        $faculti = Faculty::all();
        return view("faculties.faculties", compact("faculti"));
    }

    public function import(Request $request){
        $request -> validate([
            'file' => 'required|file|mimes:csv,pdf'
        ]);

        Excel::import(new FacultyImport, $request->file('file'));
        return redirect('/faculties')->with('success', 'se cargaron los datos');
    }
}
