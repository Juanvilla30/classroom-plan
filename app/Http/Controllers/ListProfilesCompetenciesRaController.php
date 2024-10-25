<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ListProfilesCompetenciesRaController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {
        return view('profilesCompetenciesRa.listProfilesCompetenciesRa');
    }
}
