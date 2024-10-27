<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomPlan extends Model
{
    use HasFactory;

    protected $table = 'classroom_plans';

    protected $fillable = [
        'id_course',
        'id_assignment_evaluation',
        'id_learning_result',
        'id_general_objective',
        'id_specific_objective',
        'id_general_reference',
        'id_institutional_reference',
        'id_state',
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function assignmentEvaluation()
    {
        return $this->belongsTo(AssignmentEvaluation::class, 'id_assignment_evaluation');
    }

    public function learningResult()
    {
        return $this->belongsTo(LearningResult::class, 'id_learning_result');
    }

    public function generalObjective()
    {
        return $this->belongsTo(GeneralObjective::class, 'id_general_objective');
    }

    public function specificObjective()
    {
        return $this->belongsTo(SpecificObjective::class, 'id_specific_objective');
    }

    public function generalReference()
    {
        return $this->belongsTo(GeneralReference::class, 'id_general_reference');
    }

    public function institutionalReference()
    {
        return $this->belongsTo(InstitutionalReference::class, 'id_institutional_reference');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'id_state');
    }
}
