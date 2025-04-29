<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name' ,'birthdate', 'branche_id', 'user_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Modul::class, 'modul_students')->withPivot('paid');
    }

    public function projects()
    {
        return $this->hasMany(StudentProgect::class);
    }
}
