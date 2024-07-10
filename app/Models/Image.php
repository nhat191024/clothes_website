<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = [
        'img'
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'product_id');
    }
}
