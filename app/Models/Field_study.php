<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Field_study extends Model
{
    use HasFactory;

    protected $table = 'fields_study';

    protected $fillable = [
        'name_field_study',
    ];
}
