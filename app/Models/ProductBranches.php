<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBranches extends Model
{
    protected $fillable = ['volume', 'branche_id', 'product_id'];
}
