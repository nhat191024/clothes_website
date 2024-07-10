<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    protected $table = 'product_categories';
    public $incrementing = true;
    protected $fillable = [
        'product_id',
        'category_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
