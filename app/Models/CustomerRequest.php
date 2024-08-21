<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerRequest extends Model
{
    protected $table = 'customer_requests';
    use SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'message'
    ];
}
