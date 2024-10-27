<?php

namespace App\Http\Controllers;

use App\Models\ClassroomPlan;
use App\Models\Course;
use App\Models\Evaluation;
use App\Models\Program;
use App\Models\ProgramCourseRelationship;
use App\Models\Rol;
use App\Models\Semester;
use Illuminate\Http\Request;

class ClassroomPlanController extends Controller
{

    public function index()
    {

        $programs = Program::orderBy('id')->get();
        $evaluations = Evaluation::orderBy('id')->get();
        $courses = Course::orderBy('id')->get();
        $semesters = Semester::orderBy('id')->get();

        return view('classroomPlan.classroomPlan', compact('programs', 'evaluations', 'courses', 'semesters'));
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

        //dd($listPrograms);

        // Consultar los cursos asociados
        $listCurse = Course::whereIn('id', $courseIds)
            ->with([
                'component.studyField', // Cargar la relación con el campo de estudio del componente
                'semester',             // Cargar la relación con el semestre
                'courseType'            // Cargar la relación con el tipo de curso
            ])->orderBy('id')
            ->get();

        //dd($listCurse);

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

    public function listCourses(Request $request)
    {
        // Obtener el ID del componente desde la solicitud
        $component = $request->input('component'); // Asegurarse de usar input para obtener datos del request

        // Buscar todos los cursos en la base de datos con todas las relaciones necesarias
        $curses = Course::with([
            'program.faculti',
            'component.field_study',
            'semester',
            'type_course'
        ])->where('id_component', $component)
            ->orderBy('id')
            ->get(); // Obtener todos los cursos

        // Verificar si se encontraron cursos
        if ($curses->isEmpty()) {
            return response()->json(['error' => 'No se encontraron cursos'], 404);
        }

        // Buscar los planes de aula relacionados con los cursos encontrados
        $classroomPlan = ClassroomPlan::with([
            'course',
            'course.component',
            'course.component.field_study',
            'course.semester',
            'course.type_course',
        ])->whereIn('id_course', $curses->pluck('id')) // Usar pluck para obtener solo los IDs de los cursos
            ->orderBy('id')
            ->get(); // Obtener todos los planes de aula relacionados

        // Verificar si se encontraron planes de aula
        if ($classroomPlan->isEmpty()) {
            return response()->json(['error' => 'No se encontraron planes de aula para los cursos'], 404);
        }

        // Devolver los cursos y los planes de aula como respuesta en formato JSON
        return response()->json([
            'curses' => $curses,
            'classroomPlan' => $classroomPlan
        ]);
    }


    public function visualizeCourse(Request $request)
    {
        // Obtener el ID del curso desde la solicitud
        $cursoId = $request->cursoId;

        // Buscar el curso en la base de datos con todas las relaciones necesarias
        $curse = Course::with([
            'program.faculti',
            'component.field_study',
            'semester',
            'type_course'
        ])->find($cursoId);

        // Verificar si el curso fue encontrado
        if ($curse) {
            // Devolver el curso como respuesta en formato JSON
            return response()->json(['curse' => $curse]);
        } else {
            // Enviar una respuesta de error si el curso no fue encontrado
            return response()->json(['error' => 'Curso no encontrado'], 404);
        }
    }
}
