<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UserAdmin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    protected $table = 'user_admins';

    protected $fillable = [
        'username',
        'email',
        'password',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

}
