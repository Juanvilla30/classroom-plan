<?php

namespace App\Http\Controllers;

use App\Exports\PlanAulaExport;
use App\Models\ClassroomPlan;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\Evaluation;
use App\Models\GeneralObjective;
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
    public function index($id)
    {
        try {
            return view("faculties.faculties", compact("id"));//code...
        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Error al cargar la informacion de plan aula");
        }
    }

    public function export(Request $request)
    {
        try {
            $documentId = $request->input("documentId");

            $course = Course::where('id', $documentId)
                ->with([
                    'relations.course',
                    'relations.credit'
                ])->find($documentId);

            $studyfield = StudyField::where('id', $documentId)
                ->with([
                    'name_suty_field',
                ])->find($documentId);

            $component = Component::where('id', $documentId)
                ->with([
                    'name_component'
                ])->find($documentId);

            $semester = Semester::where('id', $documentId)
                ->with([
                    'name_semester'
                ])->find($documentId);

            $coursetype = CourseType::where('id', $documentId)
                ->with([
                    'name_course_type'
                ])->find($documentId);

            $classroom = ClassroomPlan::where('id', $documentId)
                ->with([
                    'id_learning_result'
                ])->find($documentId);

            $generalobjetivs = GeneralObjective::where('id', $documentId)
                ->with([
                    'name_general_objetive'
                ])->find($documentId);

            $specificsobjetive = SpecificObjective::where('id', $documentId)
                ->with([
                    'name_specifics_objetive'
                ])->find($documentId);

            $topics = Topic::where('id', $documentId)
                ->with([
                    'description_topic'
                ])->find($documentId);

            $evaluations = Evaluation::where('id', $documentId)
                ->with([
                    'description_topic'
                ])->find($documentId);

            // return response()->json([
            //     'course' => $course,
            //     'studyfield' => $studyfield,
            //     'component' => $component,
            //     'semester' => $semester,
            //     'coursetype' => $coursetype,
            //     'classroom' => $classroom,
            //     'generalobjetivs' => $generalobjetivs,
            //     'specificsobjetive' => $specificsobjetive,
            //     'topics' => $topics,
            //     'evaluations' => $evaluations,
            // ]);

            //posible idea para que funcione la generacion de excel
            $data = [ //array con los modelos obtenidos desde el fronted
                $course => Course::all(),
                // 'credits' => Course::all(),
                $studyfield => StudyField::all(),
                $component => Component::all(),
                $semester => Semester::all(),
                $coursetype => CourseType::all(),
                $classroom => ClassroomPlan::all(),
                $generalobjetivs => GeneralObjective::all(),
                $specificsobjetive => SpecificObjective::all(),
                $topics => Topic::all(),
                $evaluations => Evaluation::all(),
            ];

            return Excel::download(new $data, 'plan-aula.xlsx');

        } catch (\Exception $e) {
            return redirect()->back()->with("error", "Error al cargar la informacion de plan aula", );
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
