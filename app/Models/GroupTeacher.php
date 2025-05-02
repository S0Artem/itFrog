<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupTeacher extends Model
{
    protected $fillable = ['employee_id', 'group_id'];
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
    
    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
