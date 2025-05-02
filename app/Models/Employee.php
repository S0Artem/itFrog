<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['id', 'branche_id'];

    public $incrementing = false;
    protected $keyType = 'integer';

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function groupTeachers()
    {
        return $this->hasMany(GroupTeacher::class, 'employee_id');
    }
    
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branche_id');
    }
}
