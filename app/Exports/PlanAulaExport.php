<?php

namespace App\Exports;

use App\Models\ClassroomPlan;
use App\Models\Component;
use App\Models\CourseType;
use App\Models\Evaluation;
use App\Models\SpecificObjective;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use App\Models\Course;
use App\Models\StudyField;
use App\Models\Semester;
use App\Models\GeneralObjective;
use App\Models\Topic;

class PlanAulaExport implements FromView
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('faculties.exportPlanAula', [
            'data' => $this->data
        ]);
    }
}