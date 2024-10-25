<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $table = 'evaluations';

    protected $fillable = [
        'name_evaluation',
        'description',
        'id_type_course',
    ];

    public function type_course()
    {
        return $this->belongsTo(Type_course::class, 'id_type_course');
    }
}
