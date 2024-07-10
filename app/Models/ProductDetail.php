<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'category_id',
        'size_id',
        'color_id'
    ];

    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function sizes()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }
    public function colors()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }

    public function bill_details()
    {
        return $this->hasMany(BillDetail::class, 'product_detail_id');
    }
}
