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
        'id_learning_result',
        'id_general_objective',
        'id_state',
    ];

    public function courses()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function learningResult()
    {
        return $this->belongsTo(LearningResult::class, 'id_learning_result');
    }

    public function generalObjective()
    {
        return $this->belongsTo(GeneralObjective::class, 'id_general_objective');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class, 'id_state');
    }
}
