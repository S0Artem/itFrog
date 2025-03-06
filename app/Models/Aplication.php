<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aplication extends Model
{
    protected $fillable = ['number', 'name', 'age', 'branche_id', 'student_id', 'employee_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    
}
