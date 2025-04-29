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

    public function time()
    {
        return $this->belongsTo(LessonTime::class, 'time_id');
    }
}
