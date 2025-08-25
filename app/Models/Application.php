<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Application extends Model
{
    use HasFactory;
    
    protected $fillable = ['number', 'email' , 'name', 'age', 'status', 'branch_id', 'user_id', 'student_id', 'employee_id', 'student_name', 'student_birth_date'];

    // Принудительно обновляем время при любых изменениях
    protected static function boot()
    {
        parent::boot();
        
        static::updating(function ($application) {
            $application->updated_at = now()->setTimezone('Europe/Moscow');
        });
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
} 