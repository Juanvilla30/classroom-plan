<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RevisionModel extends Model
{
    use HasFactory;

    protected $table = 'revision';

    protected $fillable = [
        'name_revision',
    ];
}
