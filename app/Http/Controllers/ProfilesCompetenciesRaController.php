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

    public function validateProfile(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $programId = $request->input('programId');

        // Consultar los perfiles de egreso asociados al programa
        $profileId = ProfileEgress::where('id_program', $programId)
            ->with('program')
            ->orderBy('id')
            ->get();

        // Verificar si se encontraron perfiles
        if (!$profileId->isEmpty()) {
            // Obtener los IDs de los perfiles encontrados
            $profileIdsArray = $profileId->pluck('id'); // Extraer los IDs

            // Obtener las competencias asociadas al perfil de egreso
            $competences = Competence::whereIn('id_profile_egres', $profileIdsArray)
                ->orderBy('id')
                ->get();

            // Inicializar un array para los resultados de aprendizaje
            $learningResults = [];

            // Obtener los resultados de aprendizaje para cada competencia
            foreach ($competences as $competence) {
                $rAs = LearningResult::where('id_competence', $competence->id)
                    ->orderBy('id')
                    ->get();

                // Guardar los resultados de aprendizaje en el array
                $learningResults[$competence->id] = $rAs;
            }

            // Devolver la lista como respuesta en formato JSON
            return response()->json([                
                'profileId' => $profileId,
                'competencesId' => $competences,
                'learningResultsId' => $learningResults,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron perfiles
            return response()->json([
                'confirm' => 'perfil no encontrado'
            ]);
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
        // Perfil de egreso
        $nameProfile = $request->input('nameProfile');
        $profile = $request->input('profile');
        $program = $request->input('program');

        $profileCreate = ProfileEgress::create([
            'name_profile_egres' => $nameProfile,
            'description_profile_egres' => $profile,
            'id_program' => $program,
        ]);

        // Asignar el ID del perfil creado
        $profileIdsArray = $profileCreate->id;

        // Competencias
        $nameCompetitions = [
            $request->input('nameCompetitionOne'),
            $request->input('nameCompetitionTwo')
        ];
        $competitions = [
            $request->input('competitionOne'),
            $request->input('competitionTwo')
        ];

        // Arreglo para almacenar las competencias creadas
        $createdCompetitions = [];
        $competence1 = null; // Variable para Competencia #1
        $competence2 = null; // Variable para Competencia #2

        for ($i = 0; $i < count($nameCompetitions); $i++) {
            $createdCompetition = Competence::create([
                'name_competence' => $nameCompetitions[$i],
                'description_competence' => $competitions[$i],
                'id_profile_egres' => $profileIdsArray,
            ]);

            if ($createdCompetition) {
                $createdCompetitions[] = $createdCompetition;

                if ($createdCompetition->name_competence === 'Competencias #1') {
                    $competence1 = $createdCompetition->id;
                } elseif ($createdCompetition->name_competence === 'Competencias #2') {
                    $competence2 = $createdCompetition->id;
                }
            }
        }

        // Después de crear competencias
        if (!$competence1 || !$competence2) {
            return response()->json(['error' => 'Una o más competencias no fueron creadas correctamente.'], 400);
        }
        // Resultados de aprendizaje
        $nameRas = [
            $request->input('nameRaOne'),
            $request->input('nameRaTwo'),
            $request->input('nameRaThree'),
            $request->input('nameRaFour'),
        ];
        $rAs = [
            $request->input('contentRaOne'),
            $request->input('contentRaTwo'),
            $request->input('contentRaThree'),
            $request->input('contentRaFour'),
        ];

        // Arreglo para almacenar los resultados creados
        $createdResults = [];

        // Crear cada resultado de aprendizaje y asignarlo al ID correspondiente de competencia
        for ($i = 0; $i < count($nameRas); $i++) {
            // Determinar el ID de competencia según el índice
            $competenceId = ($i < 2) ? $competence1 : $competence2;

            $createdRa = LearningResult::create([
                'name_learning_result' => $nameRas[$i],
                'description_learning_result' => $rAs[$i],
                'id_competence' => $competenceId,
            ]);

            $createdResults[] = $createdRa; 
        }


        // Verificar si el perfil se creó correctamente y devolver respuesta JSON
        if ($profileCreate) {
            return response()->json([
                'profileCreate' => $profileCreate,
                'createdCompetitions' => $createdCompetitions,
                'createdResults' => $createdResults,
            ]);
        } else {
            return response()->json(['error' => 'Datos no encontrados'], 404);
        }
    }

    public function saveCompetition(Request $request)
    {
        $competenceIds = [
            $request->input('competenceId0'),
            $request->input('competenceId1')
        ];
        $nameCompetitions = [
            $request->input('nameCompetitionOne'),
            $request->input('nameCompetitionTwo')
        ];
        $competitions = [
            $request->input('competitionOne'),
            $request->input('competitionTwo')
        ];

        $profileId = $request->input('profileId');
        $updatedCompetitions = [];

        for ($i = 0; $i < count($nameCompetitions); $i++) {
            $competenceId = $competenceIds[$i];

            $updatedCompetition = Competence::where('id', $competenceId)->update([
                'name_competence' => $nameCompetitions[$i],
                'description_competence' => $competitions[$i],
                'id_profile_egres' => $profileId,
            ]);

            if ($updatedCompetition) {
                $updatedCompetitions[] = [
                    'id' => $competenceId,
                    'name_competence' => $nameCompetitions[$i],
                    'description_competence' => $competitions[$i],
                ];
            }
        }

        if (count($updatedCompetitions) === count($nameCompetitions)) {
            return response()->json(['competitionUpdate' => $updatedCompetitions]);
        } else {
            return response()->json(['error' => 'Datos no encontrados o no se pudieron actualizar'], 404);
        }
    }

    public function saveRA(Request $request)
    {
        $RAIds = [
            $request->input('rAIdsOne'),
            $request->input('rAIdsTwo')
        ];
        $nameRas = [
            $request->input('nameRaOne'),
            $request->input('nameRaTwo'),
        ];
        $rAs = [
            $request->input('contentRaOne'),
            $request->input('contentRaTwo'),
        ];
        $competitionId = $request->input('competitions');

        $updatedResults = [];

        for ($i = 0; $i < count($nameRas); $i++) {
            $RAId = $RAIds[$i];

            $updatedRa = LearningResult::where('id', $RAId)->update([
                'name_learning_result' => $nameRas[$i],
                'description_learning_result' => $rAs[$i],
                'id_competence' => $competitionId,
            ]);

            if ($updatedRa) {
                $updatedResults[] = [
                    'id' => $RAId,
                    'name_learning_result' => $nameRas[$i],
                    'description_learning_result' => $rAs[$i],
                ];
            } 
        }

        if (count($updatedResults) === count($nameRas)) {
            return response()->json(['updatedResults' => $updatedResults]);
        } else {
            return response()->json(['error' => 'Datos no encontrados o no se pudieron actualizar'], 404);
        }
    }
}
