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
        // Obtener el ID de la facultad desde la solicitud
        $facultysId = $request->input('facultyId');

        // Obtener un array con los IDs de los programas asociados a la facultad
        $listPrograms = Program::where('id_faculty', $facultysId)->pluck('id');

        // Obtener los perfiles de egreso que pertenecen a los programas de la facultad
        $listProfiles = ProfileEgress::whereIn('id_program', $listPrograms)
            ->with(['program.faculty']) // Agrega relaciones según sea necesario
            ->orderBy('id')
            ->get();

        // Verificar si se encontraron perfiles de egreso
        if ($listProfiles->isNotEmpty()) {
            // Devolver la lista de perfiles como respuesta en formato JSON
            return response()->json([
                'listProfiles' => $listProfiles,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron perfiles
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
