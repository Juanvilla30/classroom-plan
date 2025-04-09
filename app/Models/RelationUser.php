<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelationUser extends Model
{
    use HasFactory;

    protected $table = 'relations_users';

    protected $fillable = [
        'id_relation',
        'id_user',
    ];

    public function relationProgramCourse()
    {
        return $this->belongsTo(ProgramCourseRelationship::class, 'id_relation');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
