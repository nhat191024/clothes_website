<?php

namespace App\Models;

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

    public function product()
    {
        return $this->belongsToMany(ProductDetail::class, 'product_categories', 'category_id', 'product_id');
    }
}
