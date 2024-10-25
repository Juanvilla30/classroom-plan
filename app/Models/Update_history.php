<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update_history extends Model
{
    use HasFactory;

    protected $table = 'update_histories';

    protected $fillable = [
        'update',
    ];
}
