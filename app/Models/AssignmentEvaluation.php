<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentEvaluation extends Model
{
    use HasFactory;

    protected $table = 'assignments_evaluations';

    protected $fillable = [
        'id_evaluation',
        'id_percentage',
    ];
}
