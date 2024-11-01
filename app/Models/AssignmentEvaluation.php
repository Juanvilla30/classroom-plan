<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentEvaluation extends Model
{
    use HasFactory;

    protected $table = 'assignments_evaluations';

    protected $fillable = [
        'id_evaluation',
        'id_percentage',
        'id_classroom_plan',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class, 'id_evaluation');
    }

    public function percentage()
    {
        return $this->belongsTo(Percentage::class, 'id_percentage');
    }

    public function classroomPlan()
    {
        return $this->belongsTo(ClassroomPlan::class, 'id_classroom_plan');
    }
}
