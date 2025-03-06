<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    protected $fillable = ['age', 'branche_id', 'user_id', 'aplication_id'];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function application()
    {
        return $this->belongsTo(Aplication::class);
    }

    public function modules()
    {
        return $this->belongsToMany(Modul::class, 'modul_students')->withPivot('paid');
    }

    public function projects()
    {
        return $this->hasMany(StudentProgect::class);
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
