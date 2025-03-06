<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentProgect extends Model
{
    protected $fillable = ['progect', 'student_id', 'modul_id'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }
}
