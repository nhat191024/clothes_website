<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRequest extends Model
{
    protected $table = 'customer_requests';

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message'
    ];
}
