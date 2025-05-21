<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplication extends Model
{
    protected $fillable = ['number', 'email' , 'name', 'age', 'status', 'branche_id', 'student_id', 'employee_id', 'student_name', 'student_birth_date'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
