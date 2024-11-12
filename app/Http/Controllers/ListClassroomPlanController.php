<?php

namespace App\Http\Controllers;

use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Component;
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
    public function index()
    {
        return view(
            'classroomPlan.listClassroomPlan'
        );
    }

    public function searchFaculty(Request $request)
    {
        DB::beginTransaction();
        try {

            $facultyInfo = Faculty::orderBy('id')->get();

            if ($facultyInfo->isNotEmpty()) {
                DB::commit();
                return response()->json([
                    'check' => true,
                    'facultyInfo' => $facultyInfo,
                ]);
            } else {
                DB::commit();
                return response()->json([
                    'check' => false,
                    'message' => 'No se encontraron programas para la facultad especificada.',
                ]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener los programas.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchProgram(Request $request)
    {
        DB::beginTransaction();
        try {
            $facultyId = $request->input('facultyId');
            $educationId = $request->input('educationId');

            $programInfo = Program::where('id_faculty', $facultyId)
                ->where('id_education_level', $educationId)
                ->orderBy('id')->get();

            DB::commit();
            return response()->json([
                'check' => true,
                'programInfo' => $programInfo,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener respuesta.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchCampoComun(Request $request)
    {
        DB::beginTransaction();
        try {
            $classroomTypeId = $request->input('classroomTypeId');

            $componentId = Component::where('id_study_field', $classroomTypeId)
                ->orderBy('id')->pluck('id');

            $courseId = Course::whereIn('id_component', $componentId)
                ->orderBy('id')->pluck('id');

            $relationId = ProgramCourseRelationship::whereIn('id_course', $courseId)->pluck('id');

            $classroomInfo = ClassroomPlan::whereIn('id_relations', $relationId)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                    'state',
                ])->orderBy('id')
                ->get();

            DB::commit();
            return response()->json([
                'check' => true,
                'classroomInfo' => $classroomInfo,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener respuesta.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchClassroomPlan(Request $request)
    {
        DB::beginTransaction();
        try {
            $programId = $request->input('programId');

            $relationId = ProgramCourseRelationship::where('id_program', $programId)
                ->orderBy('id')->pluck('id');

            $classroomInfo = ClassroomPlan::whereIn('id_relations', $relationId)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                    'state',
                ])->orderBy('id')
                ->get();

            DB::commit();
            return response()->json([
                'check' => true,
                'classroomInfo' => $classroomInfo,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener respuesta.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
