<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificObjective extends Model
{
    use HasFactory;

    protected $table = 'specific_objectives';

    protected $fillable = [
        'name_specific_objective',
        'description_specific_objective',
        'id_classroom_plan',
    ];

    public function classroomPlan()
    {
        return $this->belongsTo(ClassroomPlan::class, 'id_classroom_plan');
    }
}
