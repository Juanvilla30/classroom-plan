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
            return view('classroomPlan.viewClassroomPlan', 
            compact(
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
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult.competence.profileEgres.program.faculty',
                    'learningResult.competence.profileEgres.program.educationLevel',
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

}
