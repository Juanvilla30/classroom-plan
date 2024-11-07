<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
use App\Models\Program;
use Illuminate\Http\Request;

class ViewProfilesCompetenciesRaController extends Controller
{

    public function index($id)
    {

        $profileEgress = ProfileEgress::with(['program.faculty'])->find($id);

        $programId = ProfileEgress::find($id)->id_program;

        $competences = Competence::where('id_profile_egres', $id)
            ->orderBy('id')
            ->get();

        $learningResults = [];

        foreach ($competences as $competence) {
            $rAs = LearningResult::where('id_competence', $competence->id)
                ->orderBy('id')
                ->get();

            $learningResults[$competence->id] = $rAs;
        }

        return view('profilesCompetenciesRa.viewProfilesCompetenciesRa', compact(
            'profileEgress',
            'competences',
            'learningResults',
            'programId',
            'id',
        ));
    }

    public function programFaculty(Request $request)
    {
        try {
            $programId = $request->input('programId');

            $programInfo = Program::where('id', $programId)
                ->with([
                    'faculty'
                ])->orderBy('id')
                ->get();

            return response()->json([
                'programInfo' => $programInfo
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al traer datos.'
            ], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $profileId = $request->input('profileId');

        try {
            $profileUpdate = ProfileEgress::find($profileId);

            if (!$profileUpdate) {
                return response()->json(['error' => 'El perfil no fue encontrado.'], 404);
            }

            $profileUpdate->update([
                'description_profile_egres' => $request->input('textAreaProfile')
            ]);

            $competences = Competence::where('id_profile_egres', $profileId)->get();

            foreach ($competences as $competence) {
                if ($competence->name_competence === 'Competencias #1') {
                    $competence->update([
                        'description_competence' => $request->input('textAreaCompeOne')
                    ]);
                } elseif ($competence->name_competence === 'Competencias #2') {
                    $competence->update([
                        'description_competence' => $request->input('textAreaCompeTwo')
                    ]);
                }

                $learningResults = LearningResult::where('id_competence', $competence->id)->get();

                foreach ($learningResults as $learningResult) {
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

            return response()->json([
                'message' => 'El perfil de egreso se actualizó correctamente.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al actualizar el perfil de egreso.'
            ], 500);
        }
    }
}
