<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'img',
        'img_id',
        'description',
        'price',
        'sale_price'
    ];

    public function img()
    {
        return $this->belongsTo(Image::class);
    }

    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
