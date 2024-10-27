<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningResult extends Model
{
    use HasFactory;

    protected $table = 'learning_results';

    protected $fillable = [
        'name_learning_result',
        'description_learning_result',
        'id_competence',
    ];

    public function competence()
    {
        return $this->belongsTo(Competence::class, 'id_competence');
    }
}
