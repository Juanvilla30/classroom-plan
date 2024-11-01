<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $table = 'references';

    protected $fillable = [
        'name_reference',
        'link_reference',
        'id_classroom_plan',
    ];

    public function classroomPlan()
    {
        return $this->belongsTo(ClassroomPlan::class, 'id_classroom_plan');
    }
}
