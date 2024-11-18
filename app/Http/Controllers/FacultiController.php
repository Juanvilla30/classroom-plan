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
use App\Models\UserAttributes;
use Illuminate\Http\Request;
use App\Models\Faculty;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FacultyImport;
use App\Models\Program;
use App\Models\Component;
use App\Models\Percentage;
use Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use function Termwind\render;

class FacultiController extends Controller
{
    public function index()
    {
        $facultieinfo = Faculty::all();
        return view("download.downloadFiles", compact("facultieinfo"));
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

            // Obtener el nivel de educación del programa
            $a = Program::where('id', $programId)->pluck('id_education_level')->first(); // Obtener el primer valor de la colección

            if ($a == 1) {
                $relation = ProgramCourseRelationship::where('id_program', $programId)
                    ->orWhereNull('id_program')
                    ->pluck('id');
            } else {
                $relation = ProgramCourseRelationship::where('id_program', $programId)
                    ->pluck('id');
            }

            $classroomPlans = ClassroomPlan::whereIn('id_relations', $relation)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.course.user',
                    'relations.program',
                    'learningResult',
                    'generalObjective',
                ])
                ->orderBy('id')
                ->get();

            $classroomPlanIds = $classroomPlans->pluck('id')->toArray();

            $evaluationsId = AssignmentEvaluation::whereIn('id_classroom_plan', $classroomPlanIds)
                ->with('evaluation', 'percentage')
                ->orderBy('id_percentage')
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

            $percentageInfo = Percentage::orderBy('id')
                ->get();

            return Excel::download(new PlanAulaExport([
                'classroom' => $classroomPlans,
                'evaluations' => $evaluationsId,
                'references' => $referencesId,
                'specifics' => $specificsArray,
                'topics' => $topicsId,
                'percentages' => $percentageInfo,
            ]), 'plan-aula.xlsx');
        } catch (\Throwable $th) {
            Log::error('Error en export: ' . $th->getMessage());
        }
    }


    public function pdfPlanAula($id)
    {
        try {

            $classroomPlans = ClassroomPlan::where('id', $id)
                ->with([
                    'relations.course.component.studyField',
                    'relations.course.semester',
                    'relations.course.courseType',
                    'relations.program.faculty',
                    'relations.user',
                    'learningResult.competence',
                    'generalObjective',
                ])
                ->orderBy('id')
                ->get();

            $classromRelationId = $classroomPlans->pluck('id_relations');

            $userId = ProgramCourseRelationship::where('id', $classromRelationId)
                ->pluck('id_user');

            $atributesUserInfo = UserAttributes::where('id_user', $userId)->orderBy('id')
                ->get();


            $evaluationsId = AssignmentEvaluation::where('id_classroom_plan', $id)
                ->with('evaluation', 'percentage')
                ->orderBy('id_percentage')
                ->get()
                ->toArray();

            $referencesId = Reference::where('id_classroom_plan', $id)
                ->orderBy('id')
                ->get();

            $specifics = SpecificObjective::where('id_classroom_plan', $id)
                ->orderBy('id')
                ->get();

            $specificsIds = $specifics->pluck('id')->toArray();

            $specificsArray = $specifics->toArray();

            $topicsId = Topic::whereIn('id_specific_objective', $specificsIds)
                ->with('specificObjective')
                ->orderBy('id')
                ->get();

            $dompdf = new Dompdf();

            $html = view('documents.exportPdf', [
                'classroom' => $classroomPlans[0],
                'evaluations' => $evaluationsId,
                'references' => $referencesId[0],
                'specifics' => $specificsArray,
                'topics' => $topicsId,
                'atributesUser' => $atributesUserInfo[0],
            ])->render();

            $dompdf->LoadHtml($html); //renderisa el html a pdf
            $dompdf->render(); //descargar el pdf

            return $dompdf->stream("plan-aula.pdf", array("Attachment" => false));

        } catch (\Throwable $th) {
            Log::error('Error en export: ' . $th->getMessage());
        }
    }
}
