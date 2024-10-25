<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Learning_result extends Model
{
    use HasFactory;

    protected $table = 'learning_results';

    protected $fillable = [
        'name_learning_result',
    ];
}
