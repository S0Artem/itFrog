<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonReport extends Model
{
    protected $fillable = ['report', 'lesson_id', 'employee_id', 'group_id'];

}
