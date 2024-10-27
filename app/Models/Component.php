<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = 'components';

    protected $fillable = [
        'name_component',
        'id_study_field',
    ];

    public function studyField()
    {
        return $this->belongsTo(StudyField::class, 'id_study_field');
    }
}
