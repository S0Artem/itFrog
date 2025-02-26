<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplication extends Model
{
    protected $fillable = [
        'number',
        'name',
        'age',
        'brache_id',
        'student_id'
    ];
    
}
