<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'code_program',
        'name_program',
        'anio',
        'degree_type',
        'id_user',
        'id_education_level',
        'id_faculty',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function educationLevel()
    {
        return $this->belongsTo(EducationLevel::class, 'id_education_level');
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'id_faculty');
    }
}
