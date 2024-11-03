<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Course;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\SpecificObjective;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListClassroomPlanController extends Controller
{
    // Método para manejar solicitudes GET
    public function index()
    {

        $classroom = ClassroomPlan::orderBy('id')->get();
        $assigEvaluation = AssignmentEvaluation::orderBy('id')->get();
        $reference = Reference::orderBy('id')->get();
        $specificObjective = SpecificObjective::orderBy('id')->get();
        $facultys = Faculty::orderBy('id')->get();


        return view(
            'classroomPlan.listClassroomPlan',
            compact(
                'facultys',
                'classroom',
                'assigEvaluation',
                'reference',
                'specificObjective',
            )
        );
    }

    public function selectProgram(Request $request)
    {
        DB::beginTransaction();

        try {
            // Obtener el ID de la facultad desde la solicitud
            $facultysId = $request->input('facultyId');

            // Obtener un array con los IDs de los programas asociados a la facultad
            $listPrograms = Program::where('id_faculty', $facultysId)
                ->orderBy('id')
                ->get();

            // Verificar si se encontraron programas
            if ($listPrograms->isNotEmpty()) {
                // Confirmar la transacción
                DB::commit();

                // Devolver la lista de programas como respuesta en formato JSON
                return response()->json([
                    'check' => true,
                    'listPrograms' => $listPrograms,
                ]);
            } else {
                // Si no hay programas, confirmar la transacción
                DB::commit();

                // Enviar una respuesta indicando que no se encontraron programas
                return response()->json([
                    'check' => false,
                    'message' => 'No se encontraron programas para la facultad especificada.',
                ]);
            }
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
            return response()->json([
                'error' => 'No se pudo obtener los programas.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function selectClassroom(Request $request)
    {
        DB::beginTransaction();

        try {
            $programId = (array)$request->input('programId');

            $coursesId = ProgramCourseRelationship::whereIn('id_program', $programId)
                ->get('id_course');

            $listClassroom = ClassroomPlan::whereIn('id_course', $coursesId)
                ->with(['courses', 'learningResult', 'generalObjective', 'state'])
                ->get();

            DB::commit();

            if ($listClassroom->isEmpty()) {
                return response()->json([
                    'check' => false,
                    'message' => 'No se encontraron planes de aula.',
                ]);
            }

            return response()->json([
                'check' => true,
                'listClassroom' => $listClassroom,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener los planes de aula.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteClassroom(Request $request)
    {
        DB::beginTransaction();

        try {
            // Obtener el ID del perfil de egreso desde la solicitud
            $deletesId = (array) $request->input('deleteId');

            // Eliminar los resultados de aprendizaje asociados a las competencias
            Reference::whereIn('id_classroom_plan', $deletesId)->delete();
            AssignmentEvaluation::whereIn('id_classroom_plan', $deletesId)->delete();

            // Obtener IDs específicos asociados y eliminar sus temas
            $specificId = SpecificObjective::whereIn('id_classroom_plan', $deletesId)
                ->orderBy('id')
                ->pluck('id') // Usamos pluck para obtener solo un array de IDs
                ->toArray();

            Topic::whereIn('id_specific_objective', $specificId)->delete();
            SpecificObjective::whereIn('id_classroom_plan', $deletesId)->delete();
            ClassroomPlan::whereIn('id', $deletesId)->delete();

            // Confirmar la transacción
            DB::commit();

            // Devolver una respuesta indicando que la eliminación fue exitosa
            return response()->json([
                'check' => true,
                'message' => 'Los planes de aula fueron eliminados correctamente.',
            ]);
        } catch (\Exception $e) {
            // Revertir la transacción en caso de error
            DB::rollback();

            // Retornar mensaje de error
            return response()->json([
                'error' => 'No se pudo eliminar los planes de aula.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
