<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryClassroomPlan extends Model
{
    use HasFactory;

    protected $table = 'histories_classroom_plans';

    protected $fillable = [
        'id_classroom_plan',
    ];

    public function classroomPlan()
    {
        return $this->belongsTo(ClassroomPlan::class, 'id_classroom_plan');
    }
}
