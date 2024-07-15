<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAdmin extends Model
{
    protected $table = 'user_admins';

    protected $fillable = [
        'username',
        'password',
        'email',
        'status'
    ];

    protected $hidden = [
        'password'
    ];
    protected $guarded = ['status'];

}
