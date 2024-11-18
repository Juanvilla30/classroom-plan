<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramCourseRelationship extends Model
{
    use HasFactory;

    protected $table = 'programs_courses_relationships';

    protected $fillable = [
        'id_program',
        'id_course',
        'id_user',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'id_course');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
