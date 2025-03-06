<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LessonAssessment extends Model
{
    protected $fillable = ['grade', 'description', 'lesson_id', 'student_id', 'employee_id'];

}
