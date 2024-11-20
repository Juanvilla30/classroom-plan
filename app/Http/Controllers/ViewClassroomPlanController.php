<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\Evaluation;
use App\Models\GeneralObjective;
use App\Models\LearningResult;
use App\Models\Percentage;
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
            return view(
                'classroomPlan.viewClassroomPlan',
                compact(
                    'id'
                )
            );
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
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
                ])->orderBy('id_percentage')
                ->get();

            return response()->json([
                'classroomInfo' => $classroomInfo,
                'referencsInfo' => $referencsInfo,
                'specificInfo' => $specificInfo,
                'topicInfo' => $topicInfo,
                'assigEvaluationInfo' => $assigEvaluationInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function searchData(Request $request)
    {
        try {
            $programId = $request->input('programId');
            $courseTypeId = $request->input('courseTypeId');

            $profileId = ProfileEgress::where('id_program', $programId)
                ->pluck('id');

            $competenceId = Competence::whereIn('id_profile_egres', $profileId)
                ->pluck('id');

            $learningInfo = LearningResult::whereIn('id_competence', $competenceId)
                ->orderBy('id')
                ->get();

            $evaluationInfo = Evaluation::where('id_course_type', $courseTypeId)
                ->orderBy('id')
                ->get();

            $percentageInfo = Percentage::orderBy('id')->get();

            return response()->json([
                'learningInfo' => $learningInfo,
                'evaluationInfo' => $evaluationInfo,
                'percentageInfo' => $percentageInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function saveContent(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');
            $learningId = $request->input('learning');
            $dataGenerlaId = $request->input('dataGenerlaId');
            $GeneralContent = $request->input('GeneralContent');
            $specificObj = $request->input('specificObj');
            $topicObj = $request->input('topicObj');

            GeneralObjective::where('id', $dataGenerlaId)
                ->update([
                    'description_general_objective' => $GeneralContent,
                ]);

            foreach ($specificObj as $specific) {
                SpecificObjective::where('id', $specific['dataId'])
                    ->update([
                        'description_specific_objective' => $specific['value'],
                    ]);
            }

            foreach ($topicObj as $topics) {
                Topic::where('id', $topics['dataId'])
                    ->update([
                        'description_topic' => $topics['value'],
                    ]);
            }

            ClassroomPlan::where('id', $classroomId)
                ->update([
                    'id_learning_result' => $learningId,
                ]);

            return response()->json([
                'check' => true,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function saveEvaluation(Request $request)
    {
        try {
            $assignmentId = $request->input('dataValId');
            $numberData = $request->input('dataValueInput');
            $evaluationId = $request->input('dataValueSelect');

            AssignmentEvaluation::where('id', $assignmentId)
                ->update([
                    'percentage_number' => $numberData,
                    'id_evaluation' => $evaluationId,
                ]);

            $classroomPlanId = AssignmentEvaluation::where('id', $assignmentId)->value('id_classroom_plan');

            $assigEvaluationInfo = AssignmentEvaluation::where('id_classroom_plan', $classroomPlanId)
                ->with([
                    'evaluation',
                    'percentage',
                ])->orderBy('id_percentage')
                ->get();

            return response()->json([
                'check' => true,
                'assigEvaluationInfo' => $assigEvaluationInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function saveReference(Request $request)
    {
        try {
            $dataId = $request->input('dataId');
            $dataValue = $request->input('dataValue');

            Reference::where('id', $dataId)->update([
                'link_reference' => $dataValue,
            ]);

            $classroomPlanId = Reference::where('id', $dataId)->value('id_classroom_plan');

            $referencsInfo = Reference::where('id_classroom_plan', $classroomPlanId)
                ->orderBy('name_reference')
                ->get();

            return response()->json([
                'check' => true,
                'referencsInfo' => $referencsInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function createEvaluation(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');
            $percentageId = $request->input('percentageId');
            $evaluationId = $request->input('evaluationId');
            $valuePercentage = $request->input('valuePercentage');

            AssignmentEvaluation::create([
                'percentage_number' => $valuePercentage,
                'id_evaluation' => $evaluationId,
                'id_percentage' => $percentageId,
                'id_classroom_plan' => $classroomId,
            ]);

            $assigEvaluationInfo = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->with([
                    'evaluation',
                    'percentage',
                ])->orderBy('id_percentage')
                ->get();

            return response()->json([
                'check' => true,
                'assigEvaluationInfo' => $assigEvaluationInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    public function createReference(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');
            $nameReference = $request->input('nameReference');
            $linkReference = $request->input('linkReference');

            Reference::create([
                'name_reference' => $nameReference,
                'link_reference' => $linkReference,
                'id_classroom_plan' => $classroomId,
            ]);

            $referencsInfo = Reference::where('id_classroom_plan', $classroomId)
                ->orderBy('name_reference')
                ->get();

            return response()->json([
                'check' => true,
                'referencsInfo' => $referencsInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    function sendClassroom(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');

            ClassroomPlan::where('id', $classroomId)
                ->update([
                    'id_state' => 2
                ]);

            return response()->json([
                'check' => true,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    function deleteContent(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');
            $select = $request->input('select');
            $deleteId = $request->input('deleteId');

            if ($select == 1) {
                AssignmentEvaluation::where('id', $deleteId)->delete();
                $content = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                    ->with([
                        'evaluation',
                        'percentage',
                    ])->orderBy('id')->get();
                return response()->json([
                    'check' => true,
                    'assigEvaluationInfo' => $content,
                ]);
            } else {
                Reference::where('id', $deleteId)->delete();
                $content = Reference::where('id_classroom_plan', $classroomId)->orderBy('id')->get();
                return response()->json([
                    'check' => true,
                    'referencsInfo' => $content,
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }

    function validatePercentageSum(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');

            $evaluationInfo = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->orderBy('id_percentage')->get();

            return response()->json([
                'check' => true,
                'evaluationInfo' => $evaluationInfo,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with(
                'error',
                'Error al cargar la informacion.'
            );
        }
    }
}
