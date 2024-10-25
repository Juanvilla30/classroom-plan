<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        'name_program',
        'id_faculties',
    ];

    public function faculti()
    {
        return $this->belongsTo(Faculty::class, 'id_faculties');
    }
}
