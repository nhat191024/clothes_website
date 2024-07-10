<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $table = 'bills';

    protected $fillable = [
        'full_name',
        'address',
        'postcode',
        'phone',
        'email',
        'delivery_method',
        'checkout_method',
        'total_amount',
        'status'
    ];

    public function bill_details()
    {
        return $this->hasMany(BillDetail::class, 'bill_id');
    }
}
