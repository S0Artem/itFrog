<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $fillable = ['name', 'description', 'detailed_description', 'lesson', 'file', 'min_age', 'max_age', 'tags', 'direction_id'];

    public function student()
    {
        return $this->belongsToMany(Student::class, 'modul_students')->withPivot('paid');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    
    public function direction()
    {
        return $this->belongsTo(Direction::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function modulStudents()
    {
        return $this->hasMany(ModulStudent::class);
    }



    
}
