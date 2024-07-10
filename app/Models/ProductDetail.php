<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_detail';

    protected $fillable = [
        'product_id',
        'category_id',
        'size_id',
        'color_id'
    ];
}
