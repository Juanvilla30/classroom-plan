<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileEgress extends Model
{
    use HasFactory;

    protected $table = 'profiles_egress';

    protected $fillable = [
        'name_profile_egres',
        'description_profile_egres',
        'id_program',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
}
