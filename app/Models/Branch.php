<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $fillable = ['sity', 'adres'];

    public function student()
    {
        return $this->hasMany(Student::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_branches')->withPivot('volume');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
