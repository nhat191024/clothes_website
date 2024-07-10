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

    public function imgs()
    {
        return $this->belongsTo(Img::class, 'img_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class, 'product_id');
    }

    public function product_imgs()
    {
        return $this->hasMany(ProductImg::class, 'product_id');
    }

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class, 'product_id');
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class, 'product_id');
    }
}
