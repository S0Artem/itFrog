<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModulStudent extends Model
{
    protected $fillable = ['last_payment_date', 'group_id', 'student_id', 'modul_id'];
}
