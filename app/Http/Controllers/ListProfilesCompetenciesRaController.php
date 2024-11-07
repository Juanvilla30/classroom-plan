<?php

namespace App\Http\Controllers;

use App\Models\Competence;
use App\Models\Faculty;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
use App\Models\Program;
use Illuminate\Http\Request;

class ListProfilesCompetenciesRaController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {
        $facultys = Faculty::orderBy('id')->get();

        return view(
            'profilesCompetenciesRa.listProfilesCompetenciesRa',
            compact(
                'facultys',
            )
        );
    }

    public function listProfiles(Request $request)
    {
        $facultysId = $request->input('facultyId');

        if ($facultysId !== null) {
            $listPrograms = Program::where('id_faculty', $facultysId)->pluck('id');

            $listProfiles = ProfileEgress::whereIn('id_program', $listPrograms)
                ->with(['program.faculty'])
                ->orderBy('id')
                ->get();
        } else {

            $listProfiles = ProfileEgress::whereNull('id_program')
                ->orderBy('id')
                ->get();
        }

        if ($listProfiles->isNotEmpty()) {
            return response()->json([
                'listProfiles' => $listProfiles,
            ]);
        } else {
            return response()->json([
                'listProfiles' => 'Perfiles no encontrados'
            ]);
        }
    }

    public function deletefiles(Request $request)
    {
        // Obtener el ID del perfil de egreso desde la solicitud
        $deletesId = $request->input('deleteId');

        // Obtener los IDs de las competencias asociadas al perfil de egreso
        $competenceIds = Competence::where('id_profile_egres', $deletesId)->pluck('id');

        // Eliminar los resultados de aprendizaje asociados a las competencias
        $learningResultsDeleted = LearningResult::whereIn('id_competence', $competenceIds)->delete();

        // Eliminar las competencias asociadas al perfil de egreso
        $competencesDeleted = Competence::where('id_profile_egres', $deletesId)->delete();

        // Eliminar el perfil de egreso
        $profilesDeleted = ProfileEgress::where('id', $deletesId)->delete();

        return response()->json([
            'message' => 'Eliminación correcta',
            'profiles_deleted' => $profilesDeleted,
            'competences_deleted' => $competencesDeleted,
            'learning_results_deleted' => $learningResultsDeleted,
        ]);
    }
}
