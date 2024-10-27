<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstitutionalReference extends Model
{
    use HasFactory;

    protected $table = 'institutional_references';

    protected $fillable = [
        'name_institutional_reference',
        'description_institutional_reference',
    ];
}
