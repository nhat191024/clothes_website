<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = [
        'user_id',
        'full_name',
        'address',
        'phone',
        'email',
        'delivery_method',
        'payment_method',
        'total',
        'points_for_user',
        'points_use_for_payment',
        'status'
    ];

    public function billDetail()
    {
        return $this->hasMany(BillDetail::class);
    }
}
