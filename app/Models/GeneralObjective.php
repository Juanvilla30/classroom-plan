<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralObjective extends Model
{
    use HasFactory;

    protected $table = 'general_objectives';

    protected $fillable = [
        'name_general_objective',
        'description_general_objective',
    ];
}
