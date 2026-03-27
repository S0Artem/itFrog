<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'email',
        'number',
        'age',
        'status',
        'branch_id',
        'user_id',
        'student_id',
        'employee_id',
        'student_name',
        'student_birth_date',
    ];


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
} 