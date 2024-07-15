<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use SoftDeletes;
    protected $table = 'product_details';

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function color()
    {
        return $this->belongsTo(Color::class);
    }

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }
}
