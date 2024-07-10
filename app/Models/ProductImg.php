<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    protected $table = 'product_imgs';

    protected $fillable = [
        'img_id',
        'product_id'
    ];

    public function imgs()
    {
        return $this->belongsTo(Img::class, 'img_id');
    }

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
