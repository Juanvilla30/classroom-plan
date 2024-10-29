<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Faculty;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
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

    public function nameProgram(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $program = $request->input('program');

        // Consultar los programas asociados
        $listPrograms = Program::where('id', $program)
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

    public function saveProfile(Request $request)
    {
        $nameProfile = $request->input('nameProfile');
        $profile = $request->input('profile');
        $program = $request->input('program');

        $profileCreate = ProfileEgress::create([
            'name_profile_egres' => $nameProfile,
            'description_profile_egres' => $profile,
            'id_program' => $program,
        ]);

        // Verificar si se encontraron cursos
        if ($profileCreate) {
            // Devolver la lista de cursos como respuesta en formato JSON
            return response()->json([
                'profileCreate' => $profileCreate,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron cursos
            return response()->json(['error' => 'Datos no encontrados'], 404);
        }
    }

    public function saveCompetition(Request $request)
    {
        $nameCompetitions = [
            $request->input('nameCompetitionOne'),
            $request->input('nameCompetitionTwo')
        ];
        $competitions = [
            $request->input('competitionOne'),
            $request->input('competitionTwo')
        ];
        $profileId = $request->input('profileId');

        // Arreglo para almacenar las competencias creadas
        $createdCompetitions = [];

        for ($i = 0; $i < count($nameCompetitions); $i++) {
            $createdCompetition = Competence::create([
                'name_competence' => $nameCompetitions[$i],
                'description_competence' => $competitions[$i],
                'id_profile_egres' => $profileId,
            ]);

            // Agregar cada competencia creada al arreglo
            if ($createdCompetition) {
                $createdCompetitions[] = $createdCompetition;
            }
        }

        // Verificar si se crearon competencias
        if (count($createdCompetitions) === count($nameCompetitions)) {
            return response()->json([
                'competitionCreate' => $createdCompetitions,
            ]);
        } else {
            return response()->json(['error' => 'Datos no encontrados'], 404);
        }
    }

    public function saveRA(Request $request)
    {
        $nameRas = [
            $request->input('nameRaOne'),
            $request->input('nameRaTwo'),
        ];
        $rAs = [
            $request->input('contentRaOne'),
            $request->input('contentRaTwo'),
        ];
        $competitionId = $request->input('competitions');

        // Arreglo para almacenar los resultados creados
        $createdResults = [];

        // Crear cada resultado de aprendizaje
        for ($i = 0; $i < count($nameRas); $i++) {
            $createdRa = LearningResult::create([
                'name_learning_result' => $nameRas[$i],
                'description_learning_result' => $rAs[$i],
                'id_competence' => $competitionId,
            ]);
            // Agregar el resultado creado al arreglo
            $createdResults[] = $createdRa;
        }

        // Verificar si se crearon correctamente todos los resultados de aprendizaje
        if (count($createdResults) === count($nameRas)) {
            return response()->json([
                'createdResults' => $createdResults,
            ]);
        } else {
            return response()->json(['error' => 'Datos no encontrados'], 404);
        }
    }
}
