<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modul extends Model
{
    protected $fillable = ['name', 'description', 'lesson'];

    public function students()
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


    
}
