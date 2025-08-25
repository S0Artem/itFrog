<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name' ,'birthdate', 'branch_id', 'user_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
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
        return $this->hasMany(StudentProject::class);
    }
    public function modulStudents()
    {
        return $this->hasMany(ModulStudent::class);
    }
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'modul_students')
                    ->withPivot(['last_payment_date'])
                    ->withTimestamps();
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }

    public function assessments()
    {
        return $this->hasMany(LessonAssessment::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

}
