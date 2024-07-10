<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'img'
    ];

    public function products()
    {
        return $this->hasMany(Product::class, 'product_id');
    }

    public function product_imgs()
    {
        return $this->hasMany(ProductImg::class, 'img_id');
    }
}
