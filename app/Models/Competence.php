<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Competence extends Model
{
    use HasFactory;

    protected $table = 'competences';

    protected $fillable = [
        'name_competence',
        'description_competence',
        'id_profile_egres',
    ];

    public function profileEgres()
    {
        return $this->belongsTo(ProfileEgress::class, 'id_profile_egres');
    }
}
