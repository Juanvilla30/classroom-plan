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
    
    public function evaluations()
    {
        return $this->belongsTo(Evaluation::class, 'id_evaluation');
    }
    public function percentages()
    {
        return $this->belongsTo(Percentage::class, 'id_percentage');
    }
}
