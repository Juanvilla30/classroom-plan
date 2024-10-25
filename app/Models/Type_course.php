<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type_course extends Model
{
    use HasFactory;

    protected $table = 'types_courses';

    protected $fillable = [
        'name_type_course',
    ];
}
