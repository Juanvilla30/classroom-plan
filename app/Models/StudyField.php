<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyField extends Model
{
    use HasFactory;

    protected $table = 'study_fields';

    protected $fillable = [
        'name_study_field',
    ];
}
