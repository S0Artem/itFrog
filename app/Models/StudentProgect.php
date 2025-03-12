<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgect extends Model
{
    protected $table = 'student_progects';
    protected $fillable = ['progect', 'student_id', 'modul_id', 'video', 'description'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id');
    }
}