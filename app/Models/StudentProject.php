<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProject extends Model
{
    protected $table = 'student_projects';
    protected $fillable = ['project', 'student_id', 'modul_id', 'video', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
} 