<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';

    protected $fillable = [
        'code',
        'discount_percentage',
        'description',
        'min_price',
        'max_price',
        'quantity',
        'start_date',
        'end_date',
        'is_for_new_comers',
        'status'
    ];
}
