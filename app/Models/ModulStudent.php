<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModulStudent extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'last_payment_date',
        'group_id',
        'student_id',
        'modul_id',
    ];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function modul()
    {
        return $this->belongsTo(Modul::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }
}
