<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';

    protected $fillable = [
        'name',
        'image'
    ];

    public function product_details()
    {
        return $this->hasMany(ProductDetail::class, 'category_id');
    }

    public function product_categories()
    {
        return $this->hasMany(ProductCategory::class, 'category_id');
    }
}
