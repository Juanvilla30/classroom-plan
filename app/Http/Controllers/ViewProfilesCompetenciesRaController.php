<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
use Illuminate\Http\Request;

class ViewProfilesCompetenciesRaController extends Controller
{

    public function index($id)
    {
        // Buscar el perfil de egreso por ID y cargar la relación program con su facultad
        $profileEgress = ProfileEgress::with(['program.faculty'])->find($id);

        // Obtener las competencias asociadas al perfil de egreso
        $competences = Competence::where('id_profile_egres', $id)
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

        // Pasar los datos a la vista
        return view('profilesCompetenciesRa.viewProfilesCompetenciesRa', compact(
            'profileEgress',
            'competences',
            'learningResults',
            'id'
        ));
    }

    public function updateProfile(Request $request)
    {
        // Obtener el ID del perfil de egreso desde la solicitud
        $profileId = $request->input('profileId');

        try {
            // Encuentra el perfil de egreso por su ID
            $profileUpdate = ProfileEgress::find($profileId);

            // Verifica si el perfil de egreso existe
            if (!$profileUpdate) {
                return response()->json(['error' => 'El perfil no fue encontrado.'], 404);
            }

            // Actualizar el perfil de egreso
            $profileUpdate->update([
                'description_profile_egres' => $request->input('textAreaProfile')
            ]);

            // Obtener las competencias asociadas al perfil de egreso
            $competences = Competence::where('id_profile_egres', $profileId)->get();

            foreach ($competences as $competence) {
                // Actualiza las descripciones de competencia según el nombre
                if ($competence->name_competence === 'Competencias #1') {
                    $competence->update([
                        'description_competence' => $request->input('textAreaCompeOne')
                    ]);
                } elseif ($competence->name_competence === 'Competencias #2') {
                    $competence->update([
                        'description_competence' => $request->input('textAreaCompeTwo')
                    ]);
                }

                // Obtener los resultados de aprendizaje para cada competencia
                $learningResults = LearningResult::where('id_competence', $competence->id)->get();

                foreach ($learningResults as $learningResult) {
                    // Actualiza las descripciones de resultados de aprendizaje según el nombre
                    if ($learningResult->name_learning_result === 'Resultados de aprendizaje #1') {
                        $learningResult->update([
                            'description_learning_result' => $request->input('textAreaRaOne')
                        ]);
                    } elseif ($learningResult->name_learning_result === 'Resultados de aprendizaje #2') {
                        $learningResult->update([
                            'description_learning_result' => $request->input('textAreaRaTwo')
                        ]);
                    } elseif ($learningResult->name_learning_result === 'Resultados de aprendizaje #3') {
                        $learningResult->update([
                            'description_learning_result' => $request->input('textAreaRaThree')
                        ]);
                    } elseif ($learningResult->name_learning_result === 'Resultados de aprendizaje #4') {
                        $learningResult->update([
                            'description_learning_result' => $request->input('textAreaRaFour')
                        ]);
                    }
                }
            }

            // Devuelve una respuesta de éxito
            return response()->json(['message' => 'El perfil de egreso se actualizó correctamente.'], 200);
        } catch (\Exception $e) {
            // Devuelve una respuesta de error si ocurre algún problema al actualizar
            return response()->json(['error' => 'Error al actualizar el perfil de egreso.'], 500);
        }
    }
}
