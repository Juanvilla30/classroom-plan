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

    public function filtersFacultyProgram(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $faculty = $request->input('faculty');

        // Consultar los programas asociados
        $listPrograms = Program::where('id_faculty', $faculty)
            ->with([
                'faculty',
            ])->orderBy('id')
            ->get();

        // Verificar si se encontraron cursos
        if ($listPrograms) {
            // Devolver la lista de cursos como respuesta en formato JSON
            return response()->json([
                'listPrograms' => $listPrograms,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron cursos
            return response()->json(['error' => 'Cursos no encontrados'], 404);
        }
    }
}
