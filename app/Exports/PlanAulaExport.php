<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PlanAulaExport implements FromView
{
    protected $classroom;
    protected $evaluations;
    protected $references;
    protected $specifics;
    protected $topics;
    protected $percentages;

    public function __construct($data)
    {
        $this->classroom = $data['classroom'];
        $this->evaluations = $data['evaluations'];
        $this->references = $data['references'];
        $this->specifics = $data['specifics'];
        $this->topics = $data['topics'];
        $this->percentages = $data['percentages'];
    }

    public function view(): View
    {   
        //dd($this->classroom);

        return view('documents.exportExcel', [
            'classrooms' => $this->classroom,
            'evaluationss' => $this->evaluations,
            'references' => $this->references,
            'specifics' => $this->specifics,
            'topics' => $this->topics,
            'percentages' => $this->percentages,
        ]);
    }
}
