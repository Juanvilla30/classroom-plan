<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use App\Models\Program;
use Illuminate\Http\Request;

class ProfilesCompetenciesRaController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {

        $facultys = Faculty::orderBy('id')->get();
        $programs = Program::orderBy('id')->get();

        return view('profilesCompetenciesRa.profilesCompetenciesRa', compact('facultys', 'programs'));
    }
}
