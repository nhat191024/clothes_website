<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = [
        'full_name',
        'address',
        'phone',
        'email',
        'delivery_method',
        'payment_method',
        'total_amount',
        'point',
        'status'
    ];

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }
}
