<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_graduation extends Model
{
    use HasFactory;

    protected $table = 'profile_graduation';

    protected $fillable = [
        'name_profile_graduation',
    ];

}
