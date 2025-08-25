<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductBranches extends Model
{
    protected $fillable = ['volume', 'branch_id', 'product_id'];
}
