<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\SpecificObjective;
use App\Models\Topic;
use Illuminate\Http\Request;

class ViewClassroomPlanController extends Controller
{
    public function index($id)
    {
        try {
            $classroomInfo = ClassroomPlan::where("id", $id)
                ->with([
                    'courses.component.studyField',
                    'courses.educationLevel',
                    'learningResult.competence.profileEgres.program.faculty',
                    'generalObjective',
                    'state',
                ])->find($id);

            $referencsInfo = Reference::where('id_classroom_plan', $id)
                ->orderBy('id')
                ->get();

            $specificInfo = SpecificObjective::where('id_classroom_plan', $id)
                ->orderBy('id')
                ->get();

            $specificId = SpecificObjective::where('id_classroom_plan', $id)
                ->get('id');

            $topicInfo = Topic::whereIn('id_specific_objective', $specificId)
                ->orderBy('id')
                ->get();

            return view('classroomPlan.editClassroomPlan', compact(
                'classroomInfo',
                'referencsInfo',
                'specificInfo',
                'topicInfo',
                'id'
            ));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un problema al cargar la información del plan de aula.');
        }
    }

    public function ClaassroomInfo(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');

            $classroomInfo = ClassroomPlan::where("id", $classroomId)
                ->with([
                    'courses.component.studyField',
                    'learningResult.competence.profileEgres.program.faculty',
                    'generalObjective',
                    'state',
                ])->find($classroomId);

            $referencsInfo = Reference::where('id_classroom_plan', $classroomId)
                ->orderBy('name_reference')
                ->get();

            $specificInfo = SpecificObjective::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            $specificId = SpecificObjective::where('id_classroom_plan', $classroomId)
                ->get('id');

            $topicInfo = Topic::whereIn('id_specific_objective', $specificId)
                ->orderBy('id')
                ->get();

            $assigEvaluationInfo = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->with([
                    'evaluation',
                    'percentage',
                ])->orderBy('id')
                ->get();

            return response()->json([
                'classroomInfo' => $classroomInfo,
                'referencsInfo' => $referencsInfo,
                'specificInfo' => $specificInfo,
                'topicInfo' => $topicInfo,
                'assigEvaluationInfo' => $assigEvaluationInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un problema al cargar la información del plan de aula.');
        }
    }

    public function searchData(Request $request)
    {
        try {
            $programId = $request->input('programId');

            // Obtener el primer perfil de egreso asociado al programa
            $profileEgress = ProfileEgress::where('id_program', $programId)
                ->orderBy('id')
                ->first();

            // Obtener las competencias asociadas al perfil de egreso encontrado
            $competences = Competence::where('id_profile_egres', $profileEgress->id)
                ->orderBy('id')
                ->get();

            // Obtener los resultados de aprendizaje asociados a las competencias
            $learningResults = LearningResult::whereIn('id_competence', $competences->pluck('id'))
                ->orderBy('id')
                ->get();

            return response()->json([
                'check' => true,
                'profileEgress' => $profileEgress,
                'competences' => $competences,
                'learningResult' => $learningResults,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Ocurrió un problema al cargar la información del perfil de egreso.'
            );
        }
    }
}
