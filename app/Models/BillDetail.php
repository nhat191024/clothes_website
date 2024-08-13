<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_details';

    protected $fillable = [
        'product_id',
        'bill_id',
        'size_id',
        'color_id',
        'quantity',
        'price',
        'total_price'
    ];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function productDetail()
    {
        return $this->belongsTo(ProductDetail::class);
    }
}
