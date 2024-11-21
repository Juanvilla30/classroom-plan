<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\Component;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\EducationLevel;
use App\Models\Evaluation;
use App\Models\Faculty;
use App\Models\GeneralObjective;
use App\Models\LearningResult;
use App\Models\Percentage;
use App\Models\ProfileEgress;
use App\Models\Program;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\SpecificObjective;
use App\Models\State;
use App\Models\StudyField;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomPlanController extends Controller
{

    public function index()
    {
        try {
            $facultyInfo = Faculty::orderBy('id')->get();

            return view(
                'classroomPlan.classroomPlan',
                compact(
                    'facultyInfo',
                )
            );
        } catch (\Exception $e) {
            // Redireccionar o devolver una vista de error con un mensaje informativo
            return redirect()->back()->with('error', 'Ocurrió un problema al cargar la información del plan de aula.');
        }
    }

    public function searchProgram(Request $request)
    {
        try {
            $faculty = $request->input('faculty');
            $educationId = $request->input('educationId');

            $programsInfo = Program::where('id_faculty', $faculty)
                ->where('id_education_level', $educationId)
                ->with(['faculty', 'educationLevel'])
                ->orderBy('id')
                ->get();

            return response()->json([
                'check' => true,
                'programsInfo' => $programsInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al encontrar',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchCoursesRole(Request $request)
    {
        try {
            $programId = $request->input('programId');
            $userId = $request->input('userId');

            if ($userId == null) {
                $relationInfo = ProgramCourseRelationship::where('id_program', $programId)
                    ->with([
                        'program.faculty',
                        'program.educationLevel',
                        'course.component.studyField',
                        'course.semester',
                        'course.courseType',
                        'user',
                    ])->orderBy('id')
                    ->get();
                $educationId = Program::where('id', $programId)->pluck('id_education_level');
            } else {
                $relationInfo = ProgramCourseRelationship::where('id_program', $programId)
                    ->where('id_user', $userId)
                    ->with([
                        'program.faculty',
                        'program.educationLevel',
                        'course.component.studyField',
                        'course.semester',
                        'course.courseType',
                        'user',
                    ])->orderBy('id')
                    ->get();
                $educationId = Program::where('id', $programId)->pluck('id_education_level');
            }

            return response()->json([
                'check' => true,
                'relationInfo' => $relationInfo,
                'educationId' => $educationId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchCourses(Request $request)
    {
        try {
            $programId = $request->input('programId');
            $educationId = $request->input('educationId');

            if ($programId == null) {
                $relationInfo = ProgramCourseRelationship::where('id_program', $programId)
                    ->with([
                        'program.faculty',
                        'program.educationLevel',
                        'course.component.studyField',
                        'course.semester',
                        'course.courseType',
                    ])->orderBy('id')
                    ->get();
            } else {

                $programsId = Program::where('id_education_level', $educationId)
                    ->where('id', $programId)
                    ->pluck('id');

                $relationInfo = ProgramCourseRelationship::where('id_program', $programsId)
                    ->with([
                        'program.faculty',
                        'program.educationLevel',
                        'course.component.studyField',
                        'course.semester',
                        'course.courseType',
                    ])->orderBy('id')
                    ->get();
            }

            return response()->json([
                'check' => true,
                'relationInfo' => $relationInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchData(Request $request)
    {
        try {
            $classroomId = $request->input('classroomId');

            $classroomInfo = ClassroomPlan::with([
                'relations.course.component.studyField',
                'relations.course.semester',
                'relations.course.courseType',
                'relations.program',
                'learningResult',
                'generalObjective',
                'state',
            ])->where('id', $classroomId)
                ->orderBy('id')
                ->get();

            $evaluationsId = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->with('evaluation', 'percentage')
                ->orderBy('id')
                ->get();

            $referencesId = Reference::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            $specifics = SpecificObjective::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            $specificsIds = $specifics->pluck('id')->toArray();

            $specificsArray = $specifics->toArray();

            $topicsId = Topic::whereIn('id_specific_objective', $specificsIds)
                ->with('specificObjective')
                ->orderBy('id')
                ->get();

            return response()->json([
                'check' => true,
                'classroomInfo' => $classroomInfo,
                'assigEvaluationInfo' => $evaluationsId,
                'referencsInfo' => $referencesId,
                'specificInfo' => $specificsArray,
                'topicInfo' => $topicsId,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function viewInfoCourse(Request $request)
    {
        try {
            $realtionId = $request->input('realtionId');

            $relationInfo = ProgramCourseRelationship::where('id', $realtionId)
                ->with([
                    'program.faculty',
                    'program.educationLevel',
                    'course.component.studyField',
                    'course.semester',
                    'course.courseType',
                ])->orderBy('id')
                ->get();

            return response()->json([
                'check' => true,
                'relationInfo' => $relationInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function viewListCourses(Request $request)
    {
        try {
            $componentId = $request->input('componentId');
            $programId = $request->input('programId');

            $coursesInfo = Course::where('id_component', $componentId)->pluck('id');

            $relationQuery = ProgramCourseRelationship::whereIn('id_course', $coursesInfo);

            if (!is_null($programId)) {
                $relationQuery->where('id_program', $programId);
            }

            $relationId = $relationQuery->pluck('id');

            $classroomPlanInfo = ClassroomPlan::with([
                'relations.course.component.studyField',
                'relations.course.semester',
                'relations.course.courseType',
                'relations.program',
                'learningResult',
                'generalObjective',
                'state',
            ])->whereIn('id_relations', $relationId)
                ->orderBy('id')
                ->get();

            return response()->json([
                'check' => true,
                'classroomPlanInfo' => $classroomPlanInfo,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo listar los cursos',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function searchClassroomPlan(Request $request)
    {
        try {
            $realtionId = $request->input('realtionId');

            $classroomPlans = ClassroomPlan::where('id_relations', operator: $realtionId)
                ->with(
                    'relations',
                    'learningResult',
                    'generalObjective',
                    'state'
                )->orderBy('id')
                ->get();

            $classroomPlanIds = $classroomPlans->pluck('id')->toArray();

            $evaluationsId = AssignmentEvaluation::whereIn('id_classroom_plan', $classroomPlanIds)
                ->with('evaluation', 'percentage')
                ->orderBy('id')
                ->get()
                ->toArray();

            $referencesId = Reference::whereIn('id_classroom_plan', $classroomPlanIds)
                ->orderBy('id')
                ->get()
                ->toArray();

            $specifics = SpecificObjective::whereIn('id_classroom_plan', $classroomPlanIds)
                ->orderBy('id')
                ->get();

            $specificsIds = $specifics->pluck('id')->toArray();

            $specificsArray = $specifics->toArray();

            $topicsId = Topic::whereIn('id_specific_objective', $specificsIds)
                ->with('specificObjective')
                ->orderBy('id')
                ->get()
                ->toArray();

            $relationInfo = ProgramCourseRelationship::where('id', $realtionId)->pluck('id_course');

            $cursoTypeId = Course::where('id', $relationInfo)
                ->pluck('id_course_type');

            $courseTypeInfo = Evaluation::whereIn('id_course_type', $cursoTypeId)
                ->orderBy('id')
                ->get();

            if (!$classroomPlans->isEmpty()) {
                return response()->json([
                    'check' => true,
                    'classroomPlanId' => $classroomPlans,
                    'evaluationsId' => $evaluationsId,
                    'referencesId' => $referencesId,
                    'specificsId' => $specificsArray,
                    'topicsId' => $topicsId,
                ]);
            } else {
                return response()->json([
                    'check' => false,
                    'courseTypeInfo' => $courseTypeInfo,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo validar el plan de aula',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchLearning(Request $request)
    {
        try {
            $programId = $request->input('programId');

            $profileId = ProfileEgress::where('id_program', $programId)
                ->with('program')
                ->orderBy('id')
                ->get();

            if ($profileId->isNotEmpty()) {
                $profileIdsArray = $profileId->pluck('id');

                $competences = Competence::whereIn('id_profile_egres', $profileIdsArray)
                    ->orderBy('id')
                    ->get();

                $learningResults = [];

                foreach ($competences as $competence) {
                    $rAs = LearningResult::where('id_competence', $competence->id)
                        ->orderBy('id')
                        ->get();
                    $learningResults[] = $rAs;
                }

                return response()->json([
                    'check' => true,
                    'profileId' => $profileId,
                    'competencesId' => $competences,
                    'learningResultsId' => $learningResults,
                ]);
            } else {
                return response()->json([
                    'check' => false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al filtrar resultados de aprendizaje',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchDescriptionLearning(Request $request)
    {
        try {
            $learningId = $request->input('learningId');

            $learningResults = LearningResult::where('id', $learningId)
                ->orderBy('id')
                ->get();

            if (!$learningResults->isEmpty()) {
                return response()->json([
                    'learningResult' => $learningResults,
                ]);
            } else {
                return response()->json([
                    'confirm' => false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo obtener el perfil de aprendizaje', 'message' => $e->getMessage()], 500);
        }
    }

    public function createClassroomPlan(Request $request)
    {
        DB::beginTransaction();

        try {
            $realtionId = $request->input('realtionId');
            $learningId = $request->input('learningId');
            $nameGeneral = $request->input('nameGeneral');
            $content = $request->input('content');

            $nameSpecific = [
                $request->input('nameSpecificOne'),
                $request->input('nameSpecificTwo'),
                $request->input('nameSpecificThree')
            ];

            $nameReference = [
                $request->input('nameReferenceOne'),
                $request->input('nameReferenceTwo'),
            ];

            $createGeneral = GeneralObjective::create([
                'name_general_objective' =>  $nameGeneral,
                'description_general_objective' =>  $content,
            ]);

            $generalObjectiveId = $createGeneral->id;

            $statesId = State::orderBy('id')->pluck('id')->first();

            $createClassroom = ClassroomPlan::create([
                'id_relations' =>  $realtionId,
                'id_learning_result' => $learningId,
                'id_general_objective' =>  $generalObjectiveId,
                'id_state' =>  $statesId,
            ]);

            $createClassroomId = $createClassroom->id;

            $evaluationId = Evaluation::orderBy('id')->pluck('id')->first();
            $percentageIds = Percentage::orderBy('id')->pluck('id');

            $createdAssignmentEvaluationIds = [];
            $value = [30, 30, 40];
            $i = 0;
            foreach ($percentageIds as $percentageId) {
                $assignmentEvaluation = AssignmentEvaluation::create([
                    'percentage_number' => $value[$i],
                    'id_evaluation' => $evaluationId,
                    'id_percentage' => $percentageId,
                    'id_classroom_plan' => $createClassroomId,
                ]);
                $createdAssignmentEvaluationIds[] = $assignmentEvaluation->id;
                $i++;
            }

            $createSpObjective = [];

            foreach ($nameSpecific as $name) {
                $createSpecific = SpecificObjective::create([
                    'name_specific_objective' =>  $name,
                    'description_specific_objective' =>  $content,
                    'id_classroom_plan' =>  $createClassroomId,
                ]);
                $createSpObjective[] = $createSpecific->id;
            }

            $createTopics = [];
            $topicDistribution = [5, 5, 6];

            foreach ($createSpObjective as $index => $specificObjectiveId) {
                for ($i = 0; $i < $topicDistribution[$index]; $i++) {
                    $createTopic = Topic::create([
                        'description_topic' => $content,
                        'id_specific_objective' => $specificObjectiveId,
                    ]);
                    $createTopics[] = $createTopic->id;
                }
            }

            $createReferences = [];

            foreach ($nameReference as $referenceName) {
                $createReference = Reference::create([
                    'name_reference' =>  $referenceName,
                    'link_reference' =>  $content,
                    'id_classroom_plan' =>  $createClassroomId,
                ]);
                $createReferences[] = $createReference->id;
            }

            DB::commit();

            return response()->json([
                'createClassroom' => $createClassroom,
                'assignmentEvaluations' => $createdAssignmentEvaluationIds,
                'specificObjectives' => $createSpObjective,
                'topics' => $createTopics,
                'references' => $createReferences,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['error' => 'No se pudo crear el plan de aula', 'message' => $e->getMessage()], 500);
        }
    }

    public function createObjectiveGeneral(Request $request)
    {
        DB::beginTransaction();

        try {
            $classroomId = $request->input('classroomId');
            $generalObjective = $request->input('generalObjective');

            $classroomGeneral = ClassroomPlan::where('id', $classroomId)
                ->orderBy('id')
                ->first(['id_general_objective']);

            if ($classroomGeneral) {
                $classroomGenralId = $classroomGeneral->id_general_objective;

                GeneralObjective::where('id', $classroomGenralId)
                    ->update([
                        'description_general_objective' => $generalObjective,
                    ]);

                $generalId = GeneralObjective::where('id', $classroomGenralId)->first();

                DB::commit();

                return response()->json([
                    'confirm' => true,
                    'generalId' => $generalId,
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'No se encontró el ClassroomPlan asociado.'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'No se pudo Cambiar el objetivo general.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createObjectiveSpecific(Request $request)
    {
        DB::beginTransaction();

        try {
            $classroomId = $request->input('classroomId');
            $specificId = $request->input('specificId');

            $contSpecific = [
                $request->input('specificObjectiveOne'),
                $request->input('specificObjectiveTwo'),
                $request->input('specificObjectiveThree'),
            ];

            for ($i = 0; $i < count($contSpecific); $i++) {

                SpecificObjective::where('id', $specificId[$i])->update([
                    'description_specific_objective' => $contSpecific[$i],
                ]);
            }

            $specificId = SpecificObjective::where('id_classroom_plan', $classroomId)
                ->get(['id'])
                ->toArray();

            DB::commit();

            if ($specificId) {
                return response()->json([
                    'confirm' => true,
                    'specificId' => $specificId,
                ]);
            } else {
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'No se pudo crear los objetivos específicos.'
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'No se pudo cambiar el objetivo general.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createTopics(Request $request)
    {
        DB::beginTransaction();

        try {
            $specificId = $request->input('specificId');
            $contTopics = $request->input('topics');

            $topics = Topic::where('id_specific_objective', $specificId)->get();

            if (count($topics) !== count($contTopics)) {
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'El número de temas no coincide con el número de tópicos proporcionados.'
                ]);
            }

            foreach ($topics as $index => $topic) {
                if (isset($contTopics[$index])) {
                    $topic->update([
                        'description_topic' => $contTopics[$index],
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'confirm' => true,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'No se pudo cambiar el objetivo general.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createEvaluations(Request $request)
    {
        DB::beginTransaction();

        try {
            $classroomId = $request->input('classroomId');
            $assigEvaId = $request->input('assigEvaId');
            $savesEvaluation1 = $request->input('savesEvaluation1');
            $savesEvaluation2 = $request->input('savesEvaluation2');
            $savesEvaluation3 = $request->input('savesEvaluation3');

            // Agrupar los objetos de evaluación en un solo arreglo
            $savesEvaluation = [
                $savesEvaluation1,
                $savesEvaluation2,
                $savesEvaluation3
            ];

            foreach ($assigEvaId as $index => $assignmentId) {
                // Asegurarse de que exista un objeto en la posición deseada del arreglo
                if (!empty($savesEvaluation[$index]) && !empty($savesEvaluation[$index][0])) {
                    // Aquí accedemos a los elementos de tipo arreglo (sin la notación de objeto)
                    AssignmentEvaluation::where('id', $assignmentId)
                        ->update([
                            'percentage_number' => $savesEvaluation[$index][0]['percentageValue'], // Acceso como arreglo
                            'id_evaluation' => $savesEvaluation[$index][0]['evaluationId'],
                            'id_percentage' => $savesEvaluation[$index][0]['data'],
                        ]);
                }
            }

            foreach ($savesEvaluation as $index => $evaluations) {
                if (count($evaluations) > 1) {
                    for ($i = 1; $i < count($evaluations); $i++) {
                        // Aquí también accedemos a los elementos como arreglos
                        AssignmentEvaluation::create([
                            'percentage_number' => $evaluations[$i]['percentageValue'], // Acceso como arreglo
                            'id_evaluation' => $evaluations[$i]['evaluationId'],
                            'id_percentage' => $evaluations[$i]['data'],
                            'id_classroom_plan' => $classroomId,
                        ]);
                    }
                }
            }

            DB::commit();

            return response()->json([
                'confirm' => true
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'No se pudo cambiar el asignamiento.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createReferences(Request $request)
    {
        DB::beginTransaction();

        try {
            $classroomId = $request->input('classroomId');
            $referencesId = $request->input('referencesId');
            $nameReferences = $request->input('nameReferences');
            $institutionalLinks = $request->input('institutionalLinks');
            $generalLinks = $request->input('generalLinks');

            Reference::where('id', $referencesId[0])
                ->update([
                    'name_reference' => $nameReferences[0],
                    'link_reference' => $institutionalLinks[0],
                    'id_classroom_plan' => $classroomId,
                ]);

            Reference::where('id', $referencesId[1])
                ->update([
                    'name_reference' => $nameReferences[1],
                    'link_reference' => $generalLinks[0],
                    'id_classroom_plan' => $classroomId,
                ]);

            foreach (array_slice($institutionalLinks, 1) as $institutional) {
                Reference::create([
                    'name_reference' => $nameReferences[0],
                    'link_reference' => $institutional,
                    'id_classroom_plan' => $classroomId,
                ]);
            }

            foreach (array_slice($generalLinks, 1) as $general) {
                Reference::create([
                    'name_reference' => $nameReferences[1],
                    'link_reference' => $general,
                    'id_classroom_plan' => $classroomId,
                ]);
            }

            $referenceId = Reference::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            DB::commit();

            return response()->json([
                'confirm' => true,
                'referenceId' => $referenceId,
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'error' => 'No se pudo cambiar el asignamiento.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
