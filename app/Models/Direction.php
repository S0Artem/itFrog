<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Direction extends Model
{
    protected $fillable = ['name', 'description', 'detailed_description', 'photo', 'icon'];

    public function moduls()
    {
        return $this->hasMany(Modul::class);
    }

    
}
