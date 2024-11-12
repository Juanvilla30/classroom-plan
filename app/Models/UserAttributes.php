<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAttributes extends Model
{
    use HasFactory;

    protected $table = 'user_attributes';

    protected $fillable = [
        'profession',
        'postgraduate_studies',
        'specific_competences',
        'id_user',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
