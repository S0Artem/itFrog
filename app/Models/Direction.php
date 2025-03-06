<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['name', 'description', 'photo'];

    // Один ко многим, один direction может иметь много модулей
    public function moduls()
    {
        return $this->hasMany(Modul::class);
    }
}
