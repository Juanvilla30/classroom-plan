<?php

namespace App\Exports;

use App\Models\ClassroomPlan;
use App\Models\Component;
use App\Models\CourseType;
use App\Models\Evaluation;
use App\Models\SpecificObjective;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Course;
use App\Models\StudyField;
use App\Models\Semester;
use App\Models\GeneralObjective;
use App\Models\Topic;

class PlanAulaExport implements FromView
{
    public function view(): View
    {
        return view('faculties.exportPlanAula', [
            'courses' => Course::all(),
            'credits' => Course::all(),
            'studyfield' => StudyField::all(),
            'component' => Component::all(),
            'semester' => Semester::all(),
            'coursetype' => CourseType::all(),
            'classroom' => ClassroomPlan::all(),
            'generalobject' => GeneralObjective::all(),
            'specificobjetive' => SpecificObjective::all(),
            'topics' => Topic::all(),
            'evaluations' => Evaluation::all(),
        ]);
    }
}