<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Percentage extends Model
{
    use HasFactory;

    protected $table = 'percentages';

    protected $fillable = [
        'name_percentage',
        'number_percentage',
    ];

}
