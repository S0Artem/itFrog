<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'volume'];

    public function branches()
    {
        return $this->belongsToMany(Branch::class, 'product_branches')->withPivot('volume');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
