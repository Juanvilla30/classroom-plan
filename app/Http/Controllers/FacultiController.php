<?php

namespace App\Http\Controllers;

use App\Exports\PlanAulaExport;
use App\Models\ClassroomPlan;
use App\Models\Course;
use App\Models\CourseType;
use App\Models\GeneralObjective;
use App\Models\Semester;
use App\Models\SpecificObjective;
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
        $faculti = Faculty::all();
        return view("faculties.faculties");
    }

    public function export()
    {
        return Excel::download(new PlanAulaExport, 'plan-aula.xlsx');
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
