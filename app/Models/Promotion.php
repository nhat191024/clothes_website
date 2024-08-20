<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $table = 'promotions';

    protected $fillable = [
        'product_id',
        'description',
        'start_time',
        'end_time',
        'discount_percentage'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
