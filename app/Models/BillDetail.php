<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillDetail extends Model
{
    protected $table = 'bill_details';

    protected $fillable = [
        'product_detail_id',
        'bill_id',
        'quantity',
        'price',
        'total_price'
    ];
}
