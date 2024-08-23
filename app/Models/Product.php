<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    protected $table = 'products';

    protected $fillable = [
        'name',
        'img',
        'description',
        'price',
        'sale_price'
    ];

    public function image()
    {
        return $this->hasMany(Image::class);
    }

    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function bills()
    {
        return $this->belongsToMany(Bill::class, 'bill_details', 'product_id', 'bill_id');
    }

    public function promotions()
    {
        return $this->hasMany(Promotion::class,'product_id');
    }
}
