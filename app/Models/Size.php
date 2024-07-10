<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Size extends Model
{
    use SoftDeletes;
    protected $table = 'sizes';

    protected $fillable = [
        'name'
    ];

    public function productDetail()
    {
        return $this->hasMany(ProductDetail::class);
    }
}
