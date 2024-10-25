<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class General_reference extends Model
{
    use HasFactory;

    protected $table = 'general_references';

    protected $fillable = [
        'name_general_reference',
    ];
}
