<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_competition_ra extends Model
{
    use HasFactory;

    protected $table = 'profiles_competencies_ra';

    protected $fillable = [
        'id_profile_graduation',
        'id_competencies',
        'id_learning_result',
        'id_program',
    ];

    public function profile_graduation()
    {
        return $this->belongsTo(Profile_graduation::class, 'id_profile_graduation');
    }
    public function competencies()
    {
        return $this->belongsTo(Competition::class, 'id_competencies');
    }
    public function learning_result()
    {
        return $this->belongsTo(Learning_result::class, 'id_learning_result');
    }
    public function program()
    {
        return $this->belongsTo(Program::class, 'id_program');
    }
}
