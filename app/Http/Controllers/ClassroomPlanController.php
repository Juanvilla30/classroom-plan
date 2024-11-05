<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\Course;
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
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomPlanController extends Controller
{

    public function index()
    {
        try {

            $educationInfo = EducationLevel::orderBy('id')->get();

            return view(
                'classroomPlan.classroomPlan',
                compact(
                    'educationInfo',
                )
            );
        } catch (\Exception $e) {
            // Redireccionar o devolver una vista de error con un mensaje informativo
            return redirect()->back()->with('error', 'Ocurrió un problema al cargar la información del plan de aula.');
        }
    }

    public function searchFaculty(Request $request)
    {
        try {

            $facultyInfo = Faculty::orderBy('id')->get();

            if ($facultyInfo->isNotEmpty()) {
                return response()->json([
                    'check' => true,
                    'facultyInfo' => $facultyInfo,
                ]);
            } else {
                return response()->json(
                    [
                        'check' => false,
                        'error' => 'Cursos no encontrados'
                    ],404
                );
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al filtrar programas de facultad',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function filtersFacultyProgram(Request $request)
    {
        try {
            $faculty = $request->input('faculty');

            $listPrograms = Program::where('id_faculty', $faculty)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            if ($listPrograms->isNotEmpty()) {
                return response()->json([
                    'listPrograms' => $listPrograms,
                ]);
            } else {
                return response()->json(['error' => 'Cursos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al filtrar programas de facultad',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function filtersLearningProgram(Request $request)
    {
        try {
            $programId = $request->input('program');
            $learningId = $request->input('learningId');

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
                return response()->json(['check' => false]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al filtrar programas de aprendizaje',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function filtersAssignCourse(Request $request)
    {
        try {
            $program = $request->input('programs');

            $listCurseIds = ProgramCourseRelationship::where('id_program', $program)
                ->orderBy('id')
                ->get(['id_course', 'id_program']);

            $courseIds = $listCurseIds->pluck('id_course')->toArray();
            $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

            $listPrograms = Program::whereIn('id', $programIds)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            $listCurse = Course::whereIn('id', $courseIds)
                ->with([
                    'component.studyField',
                    'semester',
                    'courseType'
                ])->orderBy('id')
                ->get();

            if ($listCurse->isNotEmpty() || $listPrograms->isNotEmpty()) {
                return response()->json([
                    'listCurse' => $listCurse,
                    'listPrograms' => $listPrograms,
                ]);
            } else {
                return response()->json(['error' => 'Cursos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function filtersEvaluations(Request $request)
    {
        try {
            $typeCourseId = $request->input('typeCourse');

            $evaluationsId = Evaluation::where('id_course_type', $typeCourseId)
                ->orderBy('id')
                ->get();

            if ($evaluationsId->isNotEmpty()) {
                return response()->json([
                    'evaluationsId' => $evaluationsId,
                ]);
            } else {
                return response()->json(['error' => 'Cursos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al asignar curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function visualizeCourse(Request $request)
    {
        try {
            $cursoId = $request->courseId;

            $listCurseIds = ProgramCourseRelationship::where('id_course', $cursoId)
                ->orderBy('id')
                ->get(['id_course', 'id_program']);

            $courseIds = $listCurseIds->pluck('id_course')->toArray();
            $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

            $program = Program::whereIn('id', $programIds)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            $course = Course::with([
                'component.studyField',
                'semester',
                'courseType'
            ])->find($courseIds);

            if ($course && $program) {
                return response()->json([
                    'course' => $course,
                    'program' => $program
                ]);
            } else {
                return response()->json(['error' => 'Curso no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo visualizar el curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listCourses(Request $request)
    {
        try {
            $component = $request->input('component');

            $courses = Course::with([
                'component.studyField',
                'semester',
                'courseType'
            ])->where('id_component', $component)
                ->orderBy('id')
                ->get();

            $classroomPlan = ClassroomPlan::with([
                'courses',
                'courses.component',
                'courses.component.studyField',
                'courses.semester',
                'courses.courseType',
            ])->whereIn('id_course', $courses->pluck('id'))
                ->orderBy('id')
                ->get();

            if ($courses->isNotEmpty()) {
                return response()->json([
                    'courses' => $courses,
                    'classroomPlan' => $classroomPlan
                ]);
            } else {
                return response()->json(['error' => 'Datos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo listar los cursos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function validateClassroomPlans(Request $request)
    {
        try {
            $cursoId = $request->input('courseId');

            $classroomPlans = ClassroomPlan::where('id_course', $cursoId)
                ->with('courses', 'learningResult', 'generalObjective', 'state')
                ->orderBy('id')
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

            if (!$classroomPlans->isEmpty()) {
                return response()->json([
                    'confirm' => true,
                    'classroomPlanId' => $classroomPlans,
                    'evaluationsId' => $evaluationsId,
                    'referencesId' => $referencesId,
                    'specificsId' => $specificsArray,
                    'topicsId' => $topicsId,
                ]);
            } else {
                return response()->json([
                    'confirm' => false
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'No se pudo validar el plan de aula',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function viewLearning(Request $request)
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
            $courseId = $request->input('courseId');
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
                'id_course' =>  $courseId,
                'id_learning_result' => $learningId,
                'id_general_objective' =>  $generalObjectiveId,
                'id_state' =>  $statesId,
            ]);

            $createClassroomId = $createClassroom->id;

            $evaluationId = Evaluation::orderBy('id')->pluck('id')->first();
            $percentageIds = Percentage::orderBy('id')->pluck('id');

            $createdAssignmentEvaluationIds = [];

            foreach ($percentageIds as $percentageId) {
                $assignmentEvaluation = AssignmentEvaluation::create([
                    'id_evaluation' => $evaluationId,
                    'id_percentage' => $percentageId,
                    'id_classroom_plan' => $createClassroomId,
                ]);
                $createdAssignmentEvaluationIds[] = $assignmentEvaluation->id;
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
            $selectedEvaluations = [
                $request->input('selectedEvaluations'),
                $request->input('selectedEvaluations2'),
                $request->input('selectedEvaluations3')
            ];
            $percentageIds = [
                $request->input('percentageId1'),
                $request->input('percentageId2'),
                $request->input('percentageId3')
            ];

            foreach ($assigEvaId as $index => $assignmentId) {
                if (!empty($selectedEvaluations[$index][0])) {
                    AssignmentEvaluation::where('id', $assignmentId)
                        ->update([
                            'id_evaluation' => $selectedEvaluations[$index][0],
                            'id_percentage' => $percentageIds[$index],
                            'id_classroom_plan' => $classroomId,
                        ]);
                }
            }

            foreach ($selectedEvaluations as $index => $evaluations) {
                if (count($evaluations) > 1) {
                    for ($i = 1; $i < count($evaluations); $i++) {
                        AssignmentEvaluation::create([
                            'id_evaluation' => $evaluations[$i],
                            'id_percentage' => $percentageIds[$index],
                            'id_classroom_plan' => $classroomId,
                        ]);
                    }
                }
            }

            $evaluationsId = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            DB::commit();

            return response()->json([
                'confirm' => true,
                'evaluationsId' => $evaluationsId,
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
