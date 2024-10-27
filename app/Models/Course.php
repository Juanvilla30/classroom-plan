<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name_course',
        'credit',
        'id_modality',
        'id_component',
        'id_semester',
        'id_course_type',
        'id_role',
    ];

    public function modality()
    {
        return $this->belongsTo(Modality::class, 'id_modality');
    }

    public function component()
    {
        return $this->belongsTo(Component::class, 'id_component');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }

    public function courseType()
    {
        return $this->belongsTo(CourseType::class, 'id_course_type');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'id_role');
    }
}
