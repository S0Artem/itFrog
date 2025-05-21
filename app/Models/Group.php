<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        'branch_id',
        'modul_id',
        'time_id',
        'day'
    ];
    
    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }
    
    public function branch() 
    {
        return $this->belongsTo(Branch::class);
    }
    
    public function lessonTime() 
    {
        return $this->belongsTo(LessonTime::class, 'time_id');
    }
    public function teachers()
    {
        return $this->belongsToMany(Employee::class, 'group_teachers', 'group_id', 'employee_id');
    }

    public function time()
    {
        return $this->belongsTo(LessonTime::class, 'time_id');
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'modul_students', 'group_id', 'student_id')
            ->withPivot(['last_payment_date'])
            ->withTimestamps()
            ->with('user');;
    }
    public function teacher()
    {
        return $this->hasOne(GroupTeacher::class, 'group_id');
    }
    public function modulStudents()
    {
        return $this->hasMany(ModulStudent::class);
    }



}
