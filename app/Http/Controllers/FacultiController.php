<?php

namespace App\Http\Controllers;

use App\Exports\PlanAulaExport;
use App\Models\AssignmentEvaluation;
use App\Models\ClassroomPlan;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Evaluation;
use App\Models\GeneralObjective;
use App\Models\LearningResult;
use App\Models\ProgramCourseRelationship;
use App\Models\Reference;
use App\Models\Semester;
use App\Models\SpecificObjective;
use App\Models\StudyField;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FacultyImport;
use App\Models\Program;
use App\Models\Component;
class FacultiController extends Controller
{
    public function index()
    {
        $facultieinfo = Faculty::all();
        return view("faculties.faculties", compact("facultieinfo"));
    }

    public function searchprogram(Request $request)
    {
        try {
            $faculty = $request->input('facultyId');

            $programsInfo = Program::where('id_faculty', $faculty)
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

    public function export(Request $request)
    {
        try {
            $programId = $request->input('programId');

            $relation = ProgramCourseRelationship::where('id_program', $programId)
                ->where('id_program', null)
                ->pluck('id');

            $classroomPlans = ClassroomPlan::where('id_relations', $relation)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                ])
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


            $data = [
                'classroom'=> $classroomPlans,
                'evaluations' => $evaluationsId,
                'references' => $referencesId,
                'specifics' => $specificsArray,
                'topics' => $topicsId,
            ];

            return Excel::download(new PlanAulaExport($data), 'plan-aula.xlsx');


        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function pdfPlanAula()
    {
        $data = [
            'faculty' => Faculty::all(),
            'progrmas' => Program::all(),
            'components' => Component::all(),
            'semester' => Semester::all(),
            'credits' => Course::all(),
            'coursetype' => CourseType::all(),
            'camp' => Program::all(),
        ];
        return view('faculties.pdfPlanAula');
    }
}
