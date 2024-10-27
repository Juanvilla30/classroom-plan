<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'name_evaluation',
        'description',
        'id_course_type',
    ];

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'id_course_type');
    }
}
