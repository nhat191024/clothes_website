<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'user_admins';

    protected $fillable = [
        'username',
        'email',
    ];

}
