<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $table = 'topics';

    protected $fillable = [
        'description_topic',
        'id_specific_objective',
    ];

    public function specificObjective()
    {
        return $this->belongsTo(SpecificObjective::class, 'id_specific_objective');
    }
}
