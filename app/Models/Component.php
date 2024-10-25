<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;

    protected $table = 'components';

    protected $fillable = [
        'name_component',
        'id_field_study',
    ];

    public function field_study()
    {
        return $this->belongsTo(Field_study::class, 'id_field_study');
    }
}
