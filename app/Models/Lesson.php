<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['name', 'number_lesson', 'modul_id'];

    public function module()
    {
        return $this->belongsTo(Modul::class);
    }
}
