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
use App\Models\State;
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
            $validate = $request->input('classroomTypeId');
            $userId = $request->input('userId');

            if ($validate == 0) {
                $relationId = ProgramCourseRelationship::whereNull('id_program')
                    ->where('id_user', $userId)
                    ->pluck('id');
            } else {
                $relationId = ProgramCourseRelationship::where('id_program', null)->pluck('id');
            }

            $classroomInfo = ClassroomPlan::whereIn('id_relations', $relationId)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                    'state',
                ])->orderBy('id_state')
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
            $userId = $request->input('userId');
            $userRoleId = $request->input('userRoleId');

            if ($userRoleId == 1 || $userRoleId == 2) {
                $relationId = ProgramCourseRelationship::where('id_program', $programId)
                    ->orderBy('id')->pluck('id');
            } else if($userRoleId == 3){
                $relationId = ProgramCourseRelationship::whereNull('id_program')
                    ->orWhere('id_program', $programId)
                    ->pluck('id');
            } else {
                $relationId = ProgramCourseRelationship::where('id_program', $programId)
                    ->where('id_user', $userId)
                    ->orderBy('id')->pluck('id');
            }
            $classroomInfo = ClassroomPlan::whereIn('id_relations', $relationId)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                    'state',
                ])->orderBy('id_state')
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

    public function searchInfoEducation(Request $request)
    {
        DB::beginTransaction();
        try {
            $userProgramId = $request->input('userProgramId');

            $educationId = Program::where('id', $userProgramId)->pluck('id_education_level');

            DB::commit();
            return response()->json([
                'check' => true,
                'educationId' => $educationId,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener respuesta.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function searchData(Request $request)
    {
        DB::beginTransaction();
        try {
            $classroomId = $request->input('classroomId');

            $classroomInfo = ClassroomPlan::where('id', $classroomId)
                ->with([
                    'state'
                ])->get();

            $stateInfo = State::orderBy('id')->get();

            DB::commit();
            return response()->json([
                'check' => true,
                'classroomInfo' => $classroomInfo,
                'stateInfo' => $stateInfo,
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'No se pudo obtener respuesta.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function saveUpdateState(Request $request)
    {
        DB::beginTransaction();
        try {
            $classroomId = $request->input('classroomId');
            $dataValueSelec = $request->input('dataValueSelec');

            ClassroomPlan::where('id', $classroomId)
                ->update([
                    'id_state' => $dataValueSelec
                ]);

            DB::commit();
            return response()->json([
                'check' => true,
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
