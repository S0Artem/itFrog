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
    // Group.php
    public function teachers()
    {
        return $this->belongsToMany(Employee::class, 'group_teachers', 'group_id', 'employee_id');
    }

    public function time()
    {
        return $this->belongsTo(LessonTime::class, 'time_id');
    }
    public function student()
    {
        return $this->belongsToMany(
            Student::class,
            'modul_students',
            'group_id',
            'student_id'
        )->withTimestamps();
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
