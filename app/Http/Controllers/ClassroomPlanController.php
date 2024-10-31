<?php

namespace App\Http\Controllers;

use App\Models\ClassroomPlan;
use App\Models\Competence;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Faculty;
use App\Models\LearningResult;
use App\Models\ProfileEgress;
use App\Models\Program;
use App\Models\ProgramCourseRelationship;
use App\Models\Semester;
use Illuminate\Http\Request;

class ClassroomPlanController extends Controller
{

    public function index()
    {
        $facultys = Faculty::orderBy('id')->get();
        $programs = Program::orderBy('id')->get();
        $evaluations = Evaluation::orderBy('id')->get();
        $courses = Course::orderBy('id')->get();
        $semesters = Semester::orderBy('id')->get();

        return view(
            'classroomPlan.classroomPlan',
            compact(
                'programs',
                'evaluations',
                'courses',
                'semesters',
                'facultys'
            )
        );
    }

    public function filtersFacultyProgram(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $faculty = $request->input('faculty');

        // Consultar los programas asociados
        $listPrograms = Program::where('id_faculty', $faculty)
            ->with([
                'faculty',
            ])->orderBy('id')
            ->get();

        // Verificar si se encontraron cursos
        if ($listPrograms) {
            // Devolver la lista de cursos como respuesta en formato JSON
            return response()->json([
                'listPrograms' => $listPrograms,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron cursos
            return response()->json(['error' => 'Cursos no encontrados'], 404);
        }
    }

    public function filtersLearningProgram(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $programId = $request->input('program');
        $learningId = $request->input('learningId');

        // Consultar los perfiles de egreso asociados al programa
        $profileId = ProfileEgress::where('id_program', $programId)
            ->with('program')
            ->orderBy('id')
            ->get();

        // Verificar si se encontraron perfiles
        if (!$profileId->isEmpty()) {
            // Obtener los IDs de los perfiles encontrados
            $profileIdsArray = $profileId->pluck('id'); // Extraer los IDs

            // Obtener las competencias asociadas al perfil de egreso
            $competences = Competence::whereIn('id_profile_egres', $profileIdsArray)
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
                $learningResults[] = $rAs;
            }

            // Devolver la lista como respuesta en formato JSON
            return response()->json([
                'check' => true,
                'profileId' => $profileId,
                'competencesId' => $competences,
                'learningResultsId' => $learningResults,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron perfiles
            return response()->json([
                'check' => false
            ]);
        }
    }

    public function filtersAssignCourse(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $program = $request->input('programs');

        // Consultar los registros de relación de programa y curso
        $listCurseIds = ProgramCourseRelationship::where('id_program', $program)
            ->orderBy('id') // Ordenar los resultados por ID
            ->get(['id_course', 'id_program']); // Obtener solo los IDs de curso y programa

        // Extraer los IDs de curso y programa de los resultados obtenidos
        $courseIds = $listCurseIds->pluck('id_course')->toArray();
        $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

        // Consultar los programas asociados
        $listPrograms = Program::whereIn('id', $programIds)
            ->with([
                'faculty',
            ])->orderBy('id')
            ->get();

        // Consultar los cursos asociados
        $listCurse = Course::whereIn('id', $courseIds)
            ->with([
                'component.studyField', // Cargar la relación con el campo de estudio del componente
                'semester',             // Cargar la relación con el semestre
                'courseType'            // Cargar la relación con el tipo de curso
            ])->orderBy('id')
            ->get();

        // Verificar si se encontraron cursos
        if ($listCurse || $listPrograms) {
            // Devolver la lista de cursos como respuesta en formato JSON
            return response()->json([
                'listCurse' => $listCurse,
                'listPrograms' => $listPrograms,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron cursos
            return response()->json(['error' => 'Cursos no encontrados'], 404);
        }
    }


    public function visualizeCourse(Request $request)
    {
        // Obtener el ID del curso desde la solicitud
        $cursoId = $request->cursoId;

        // Consultar los registros de relación de programa y curso
        $listCurseIds = ProgramCourseRelationship::where('id_course', $cursoId)
            ->orderBy('id') // Ordenar los resultados por ID
            ->get(['id_course', 'id_program']); // Obtener solo los IDs de curso y programa

        // Extraer los IDs de curso y programa de los resultados obtenidos
        $courseIds = $listCurseIds->pluck('id_course')->toArray();
        $programIds = $listCurseIds->pluck('id_program')->unique()->toArray();

        // Consultar los programas asociados
        $program = Program::whereIn('id', $programIds)
            ->with([
                'faculty',
            ])->orderBy('id')
            ->get();

        //dd($listPrograms);

        // Buscar el curso en la base de datos con todas las relaciones necesarias
        $course = Course::with([
            'component.studyField', // Cargar la relación con el campo de estudio del componente
            'semester',             // Cargar la relación con el semestre
            'courseType'            // Cargar la relación con el tipo de curso
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
    }

    public function listCourses(Request $request)
    {
        // Obtener el ID del componente desde la solicitud
        $component = $request->input('component'); // Asegurarse de usar input para obtener datos del request

        // Buscar todos los cursos en la base de datos con todas las relaciones necesarias
        $courses = Course::with([
            'component.studyField', // Cargar la relación con el campo de estudio del componente
            'semester',             // Cargar la relación con el semestre
            'courseType'            // Cargar la relación con el tipo de curso
        ])->where('id_component', $component)
            ->orderBy('id')
            ->get(); // Obtener todos los cursos

        // Buscar los planes de aula relacionados con los cursos encontrados
        $classroomPlan = ClassroomPlan::with([
            'courses',
            'courses.component',
            'courses.component.studyField',
            'courses.semester',
            'courses.courseType',
        ])->whereIn('id_course', $courses->pluck('id')) // Usar pluck para obtener solo los IDs de los cursos
            ->orderBy('id')
            ->get(); // Obtener todos los planes de aula relacionados

        // Verificar si el curso fue encontrado
        if ($courses && $classroomPlan) {
            // Devolver los cursos y los planes de aula como respuesta en formato JSON
            return response()->json([
                'courses' => $courses,
                'classroomPlan' => $classroomPlan
            ]);
        } else {
            // Enviar una respuesta de error si el curso no fue encontrado
            return response()->json(['error' => 'Datos no encontrado'], 404);
        }
    }

    public function validateClassroomPlans(Request $request)
    {
        // Obtener el programa de los datos de la solicitud
        $cursoId = $request->input('cursoId');

        $classroomPlanId = ClassroomPlan::where('id_course', $cursoId)
            ->with(
                'courses',
                'assignmentEvaluation',
                'learningResult',
                'generalObjective',
                'specificObjective',
                'generalReference',
                'institutionalReference',
                'state'
            )->orderBy('id')
            ->get();


        // Verificar si se encontraron perfiles
        if (!$classroomPlanId->isEmpty()) {

            // Devolver la lista como respuesta en formato JSON
            return response()->json([
                'confirm' => 'true',
                'classroomPlanId' => $classroomPlanId,
            ]);
        } else {
            // Enviar una respuesta de error si no se encontraron perfiles
            return response()->json([
                'confirm' => 'false'
            ]);
        }
    }
    public function viewLearning(Request $request)
    {
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
                'confirm' => 'perfil no encontrado'
            ]);
        }
    }

    public function createClassroomPlan(Request $request)
    {
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
                'confirm' => 'perfil no encontrado'
            ]);
        }
    }
}
