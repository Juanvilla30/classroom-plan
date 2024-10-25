<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specific_objective extends Model
{
    use HasFactory;

    protected $table = 'specific_objectives';

    protected $fillable = [
        'name_specific_objective',
        'id_topic',
    ];

    public function topic()
    {
        return $this->belongsTo(Topic::class, 'id_topic');
    }
}
