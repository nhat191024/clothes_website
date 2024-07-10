<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactInfo extends Model
{
    protected $table = 'contact_info';

    protected $fillable = [
        'name',
        'type',
    ];
}
