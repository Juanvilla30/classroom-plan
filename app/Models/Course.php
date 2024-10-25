<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name_curse',
        'credit',
        'id_modalitie',
        'id_program',
        'id_component',
        'id_semester',
        'id_type_course',
        'id_rol',
    ];

    public function modalitie()
    {
        return $this->belongsTo(Modality::class, 'id_modalitie');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
    public function component()
    {
        return $this->belongsTo(Component::class, 'id_component');
    }
    public function semester()
    {
        return $this->belongsTo(Semester::class, 'id_semester');
    }
    public function type_course()
    {
        return $this->belongsTo(Type_course::class, 'id_type_course');
    }
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }
}
