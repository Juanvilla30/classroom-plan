<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Evaluation;
use App\Models\Faculty;
use App\Models\GeneralObjective;
use App\Models\LearningResult;
use App\Models\Percentage;
use App\Models\ProfileEgress;
use App\Models\Program;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\Semester;
use App\Models\SpecificObjective;
use App\Models\State;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClassroomPlanController extends Controller
{

    public function index()
    {
        $facultys = Faculty::orderBy('id')->get();

        return view(
            'classroomPlan.classroomPlan',
            compact(
                'facultys',
            )
        );
    }

    public function filtersFacultyProgram(Request $request)
    {
        try {
            // Obtener el programa de los datos de la solicitud
            $faculty = $request->input('faculty');

            // Consultar los programas asociados
            $listPrograms = Program::where('id_faculty', $faculty)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            // Verificar si se encontraron cursos
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

            // Consultar los perfiles de egreso asociados al programa
            $profileId = ProfileEgress::where('id_program', $programId)
                ->with('program')
                ->orderBy('id')
                ->get();

            // Verificar si se encontraron perfiles
            if ($profileId->isNotEmpty()) {
                $profileIdsArray = $profileId->pluck('id');

                // Obtener las competencias asociadas al perfil de egreso
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

            // Consultar los registros de relación de programa y curso
            $listCurseIds = ProgramCourseRelationship::where('id_program', $program)
                ->orderBy('id')
                ->get(['id_course', 'id_program']);

            $courseIds = $listCurseIds->pluck('id_course')->toArray();
            $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

            // Consultar los programas asociados
            $listPrograms = Program::whereIn('id', $programIds)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            // Consultar los cursos asociados
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

            // Consultar los registros de relación de programa y curso
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
            // Obtener el ID del curso desde la solicitud
            $cursoId = $request->courseId;

            // Consultar los registros de relación de programa y curso
            $listCurseIds = ProgramCourseRelationship::where('id_course', $cursoId)
                ->orderBy('id')
                ->get(['id_course', 'id_program']);

            // Extraer los IDs de curso y programa de los resultados obtenidos
            $courseIds = $listCurseIds->pluck('id_course')->toArray();
            $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

            // Consultar los programas asociados
            $program = Program::whereIn('id', $programIds)
                ->with(['faculty'])
                ->orderBy('id')
                ->get();

            // Buscar el curso en la base de datos con todas las relaciones necesarias
            $course = Course::with([
                'component.studyField',
                'semester',
                'courseType'
            ])->find($courseIds);

            // Verificar si el curso fue encontrado
            if ($course && $program) {
                // Devolver el curso como respuesta en formato JSON
                return response()->json([
                    'course' => $course,
                    'program' => $program
                ]);
            } else {
                // Enviar una respuesta de error si el curso no fue encontrado
                return response()->json(['error' => 'Curso no encontrado'], 404);
            }
        } catch (\Exception $e) {
            // Retornar mensaje de error en caso de excepción
            return response()->json([
                'error' => 'No se pudo visualizar el curso',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function listCourses(Request $request)
    {
        try {
            // Obtener el ID del componente desde la solicitud
            $component = $request->input('component');

            // Buscar todos los cursos en la base de datos con todas las relaciones necesarias
            $courses = Course::with([
                'component.studyField',
                'semester',
                'courseType'
            ])->where('id_component', $component)
                ->orderBy('id')
                ->get();

            // Buscar los planes de aula relacionados con los cursos encontrados
            $classroomPlan = ClassroomPlan::with([
                'courses',
                'courses.component',
                'courses.component.studyField',
                'courses.semester',
                'courses.courseType',
            ])->whereIn('id_course', $courses->pluck('id'))
                ->orderBy('id')
                ->get();

            // Verificar si los cursos y planes de aula fueron encontrados
            if ($courses->isNotEmpty()) {
                // Devolver los cursos y los planes de aula como respuesta en formato JSON
                return response()->json([
                    'courses' => $courses,
                    'classroomPlan' => $classroomPlan
                ]);
            } else {
                // Enviar una respuesta de error si no se encontraron datos
                return response()->json(['error' => 'Datos no encontrados'], 404);
            }
        } catch (\Exception $e) {
            // Retornar mensaje de error en caso de excepción
            return response()->json([
                'error' => 'No se pudo listar los cursos',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function validateClassroomPlans(Request $request)
    {
        try {
            // Obtener el programa de los datos de la solicitud
            $cursoId = $request->input('courseId');

            // Consultar los planes de aula asociados al curso y extraer los IDs
            $classroomPlans = ClassroomPlan::where('id_course', $cursoId)
                ->with('courses', 'learningResult', 'generalObjective', 'state')
                ->orderBy('id')
                ->get();

            // Convertir classroomPlan en un array de IDs
            $classroomPlanIds = $classroomPlans->pluck('id')->toArray();

            // Consultar las evaluaciones asociadas al plan de aula
            $evaluationsId = AssignmentEvaluation::whereIn('id_classroom_plan', $classroomPlanIds)
                ->with('evaluation', 'percentage')
                ->orderBy('id')
                ->get()
                ->toArray(); // Obtener solo los IDs como array

            // Consultar las referencias asociadas al plan de aula
            $referencesId = Reference::whereIn('id_classroom_plan', $classroomPlanIds)
                ->orderBy('id')
                ->get()
                ->toArray(); // Obtener solo los IDs como array

            // Consultar todos los registros de los objetivos específicos asociados al plan de aula
            $specifics = SpecificObjective::whereIn('id_classroom_plan', $classroomPlanIds)
                ->orderBy('id')
                ->get();

            // Convertir la colección de objetivos específicos en un array de IDs
            $specificsIds = $specifics->pluck('id')->toArray();

            // Convertir todos los registros de objetivos específicos a array
            $specificsArray = $specifics->toArray();

            // Consultar los temas asociados a los objetivos específicos
            $topicsId = Topic::whereIn('id_specific_objective', $specificsIds)
                ->with('specificObjective')
                ->orderBy('id')
                ->get()
                ->toArray(); // Obtener solo los IDs como array

            // Verificar si se encontraron planes de aula
            if (!$classroomPlans->isEmpty()) {
                // Devolver la lista como respuesta en formato JSON
                return response()->json([
                    'confirm' => true,
                    'classroomPlanId' => $classroomPlans,
                    'evaluationsId' => $evaluationsId,
                    'referencesId' => $referencesId,
                    'specificsId' => $specificsArray,
                    'topicsId' => $topicsId,
                ]);
            } else {
                // Enviar una respuesta de error si no se encontraron planes
                return response()->json([
                    'confirm' => false
                ]);
            }
        } catch (\Exception $e) {
            // Retornar mensaje de error en caso de excepción
            return response()->json([
                'error' => 'No se pudo validar el plan de aula',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function viewLearning(Request $request)
    {
        try {
            // Obtener el programa de los datos de la solicitud
            $learningId = $request->input('learningId');

            // Consultar los perfiles de egreso asociados al programa
            $learningResults = LearningResult::where('id', $learningId)
                ->orderBy('id')
                ->get();

            // Verificar si se encontraron perfiles
            if (!$learningResults->isEmpty()) {
                // Devolver la lista como respuesta en formato JSON
                return response()->json([
                    'learningResult' => $learningResults,
                ]);
            } else {
                // Enviar una respuesta de error si no se encontraron perfiles
                return response()->json([
                    'confirm' => false
                ]);
            }
        } catch (\Exception $e) {
            // Retornar mensaje de error en caso de excepción
            return response()->json(['error' => 'No se pudo obtener el perfil de aprendizaje', 'message' => $e->getMessage()], 500);
        }
    }

    public function createClassroomPlan(Request $request)
    {
        DB::beginTransaction();

        try {
            // Obtener el programa de los datos de la solicitud
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

            // Crear el objetivo general
            $createGeneral = GeneralObjective::create([
                'name_general_objective' =>  $nameGeneral,
                'description_general_objective' =>  $content,
            ]);

            // Obtener el ID del objetivo general creado
            $generalObjectiveId = $createGeneral->id;

            // Obtener el primer id de evaluación y el primer estado
            $statesId = State::orderBy('id')->pluck('id')->first();

            // Crear el plan de aula
            $createClassroom = ClassroomPlan::create([
                'id_course' =>  $courseId,
                'id_learning_result' => $learningId,
                'id_general_objective' =>  $generalObjectiveId,
                'id_state' =>  $statesId,
            ]);

            // Obtener el ID del plan de aula creado
            $createClassroomId = $createClassroom->id;

            // Obtener el primer id de evaluación y todos los ids de porcentaje
            $evaluationId = Evaluation::orderBy('id')->pluck('id')->first();
            $percentageIds = Percentage::orderBy('id')->pluck('id');

            $createdAssignmentEvaluationIds = [];

            // Crear registros en AssignmentEvaluation para cada id de porcentaje
            foreach ($percentageIds as $percentageId) {
                $assignmentEvaluation = AssignmentEvaluation::create([
                    'id_evaluation' => $evaluationId,
                    'id_percentage' => $percentageId,
                    'id_classroom_plan' => $createClassroomId,
                ]);
                $createdAssignmentEvaluationIds[] = $assignmentEvaluation->id;
            }

            $createSpObjective = [];

            // Crear cada objetivo específico
            foreach ($nameSpecific as $name) {
                $createSpecific = SpecificObjective::create([
                    'name_specific_objective' =>  $name,
                    'description_specific_objective' =>  $content,
                    'id_classroom_plan' =>  $createClassroomId,
                ]);
                $createSpObjective[] = $createSpecific->id;
            }

            // Crear topics para cada objetivo específico
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

            // Crear referencias
            foreach ($nameReference as $referenceName) {
                $createReference = Reference::create([
                    'name_reference' =>  $referenceName,
                    'link_reference' =>  $content,
                    'id_classroom_plan' =>  $createClassroomId,
                ]);
                $createReferences[] = $createReference->id;
            }

            // Confirmar la transacción
            DB::commit();

            // Retornar respuesta JSON con todos los IDs creados
            return response()->json([
                'createClassroom' => $createClassroom,
                'assignmentEvaluations' => $createdAssignmentEvaluationIds,
                'specificObjectives' => $createSpObjective,
                'topics' => $createTopics,
                'references' => $createReferences,
            ]);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
            return response()->json(['error' => 'No se pudo crear el plan de aula', 'message' => $e->getMessage()], 500);
        }
    }

    public function createObjectiveGeneral(Request $request)
    {
        DB::beginTransaction();

        try {
            $classroomId = $request->input('classroomId');
            $generalObjective = $request->input('generalObjective');

            // Obtener el ID del objetivo general asociado al plan de aula
            $classroomGeneral = ClassroomPlan::where('id', $classroomId)
                ->orderBy('id')
                ->first(['id_general_objective']);

            // Asegurarse de que se encontró el registro antes de continuar
            if ($classroomGeneral) {
                $classroomGenralId = $classroomGeneral->id_general_objective;

                // Actualizar el objetivo general
                GeneralObjective::where('id', $classroomGenralId)
                    ->update([
                        'description_general_objective' => $generalObjective,
                    ]);

                // Obtener el registro actualizado
                $generalId = GeneralObjective::where('id', $classroomGenralId)->first();

                // Confirmar la transacción
                DB::commit();

                // Verificar si se encontró el registro y devolver la respuesta
                return response()->json([
                    'confirm' => true,
                    'generalId' => $generalId,
                ]);
            } else {
                // Enviar una respuesta de error si no se encontró el ClassroomPlan
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'No se encontró el ClassroomPlan asociado.'
                ]);
            }
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
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

            // Obtener los objetivos específicos desde la petición
            $contSpecific = [
                $request->input('specificObjectiveOne'),
                $request->input('specificObjectiveTwo'),
                $request->input('specificObjectiveThree'),
            ];

            for ($i = 0; $i < count($contSpecific); $i++) {

                SpecificObjective::where('id_classroom_plan', $classroomId)->update([
                    'description_specific_objective' => $contSpecific[$i],
                ]);
            }

            // Obtener los registros actualizados
            $specificId = SpecificObjective::where('id_classroom_plan', $classroomId)
                ->get(['id'])
                ->toArray();

            // Confirmar la transacción
            DB::commit();

            // Asegurarse de que se encontró el registro antes de continuar
            if ($specificId) {
                // Devolver la respuesta
                return response()->json([
                    'confirm' => true,
                    'specificId' => $specificId,
                ]);
            } else {
                // Enviar una respuesta de error si no se encontró el ClassroomPlan
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'No se pudo crear los objetivos específicos.'
                ]);
            }
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
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

            // Obtener los temas existentes para el id específico
            $topics = Topic::where('id_specific_objective', $specificId)->get();

            // Verificar si el número de temas existentes coincide con el número de contenidos
            if (count($topics) !== count($contTopics)) {
                DB::rollBack();
                return response()->json([
                    'confirm' => false,
                    'error' => 'El número de temas no coincide con el número de tópicos proporcionados.'
                ]);
            }

            // Actualizar cada tema individualmente
            foreach ($topics as $index => $topic) {
                if (isset($contTopics[$index])) { // Asegúrate de que el índice existe
                    $topic->update([
                        'description_topic' => $contTopics[$index],
                    ]);
                }
            }

            // Confirmar la transacción
            DB::commit();

            // Devolver la respuesta
            return response()->json([
                'confirm' => true,
            ]);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
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
            $selectedEvaluations = $request->input('selectedEvaluations');
            $selectedEvaluations2 = $request->input('selectedEvaluations2');
            $selectedEvaluations3 = $request->input('selectedEvaluations3');
            $percentageId1 = $request->input('percentageId1');
            $percentageId2 = $request->input('percentageId2');
            $percentageId3 = $request->input('percentageId3');

            for ($i = 0; $i < count($selectedEvaluations); $i++) {

                AssignmentEvaluation::where('id_classroom_plan', $classroomId)->update([
                    'id_evaluation' => $selectedEvaluations[$i],
                    'id_percentage' => $percentageId1,
                    'id_classroom_plan' => $classroomId,
                ]);
            }

            for ($i = 0; $i < count($selectedEvaluations2); $i++) {

                AssignmentEvaluation::where('id_classroom_plan', $classroomId)->update([
                    'id_evaluation' => $selectedEvaluations2[$i],
                    'id_percentage' => $percentageId2,
                    'id_classroom_plan' => $classroomId,
                ]);
            }

            for ($i = 0; $i < count($selectedEvaluations3); $i++) {

                AssignmentEvaluation::where('id_classroom_plan', $classroomId)->update([
                    'id_evaluation' => $selectedEvaluations3[$i],
                    'id_percentage' => $percentageId3,
                    'id_classroom_plan' => $classroomId,
                ]);
            }

            $evaluationsId = AssignmentEvaluation::where('id_classroom_plan', $classroomId)
                ->orderBy('id')
                ->get();

            // Confirmar la transacción
            DB::commit();

            // Devolver la respuesta
            return response()->json([
                'confirm' => true,
                'evaluationsId' => $evaluationsId,
            ]);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
            return response()->json([
                'error' => 'No se pudo cambiar el objetivo general.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
