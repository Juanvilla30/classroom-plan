<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecificObjective extends Model
{
    use HasFactory;

    protected $table = 'specific_objectives';

    protected $fillable = [
        'name_specific_objective',
        'description_specific_objective',
        'id_topics',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'id_topics');
    }
}
