<?php

namespace App\Service\admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function getAll()
    {
        return User::all();
    }

    public function getById($id) {
        return User::where('id', $id)->first();
    }

    // add($username, $fullname, $email, $phone, $password, $status);
    public function add($username, $fullname, $email, $phone, $password, $status)
    {
        $user = new User();
        $user->username = $username;
        $user->full_name = $fullname;
        $user->email = $email;
        $user->phone = $phone;
        $user->point = 0;
        $user->password = Hash::make($password);
        $user->status = $status;
        $user->save();
    }

    public function edit($id, $username, $fullname = null, $email, $phone, $point = null, $password = null, $status = null, $imageName = null)
    {
        $user = User::where('id', $id)->first();
        $user->username = $username;
        $user->email = $email;
        $user->phone = $phone;
        if ($fullname != null) {
            $user->full_name = $fullname;
        }
        if ($point != null) {
            $user->point = $point;
        }
        if ($password != null) {
            $user->password = Hash::make($password);
        }
        if ($status != null) {
            $user->status = $status;
        }
        if ($imageName != null) {
            $user->avt = $imageName;
        }
        $user->save();
    }

    public function lock($idUser)
    {
        $user = User::find($idUser);
        $user->status = 0;
        $user->save();
    }
    public function delete($idUser)
    {
        $user = User::find($idUser);
        $user->delete();
    }

    public function unlock($idUser)
    {
        $user = User::find($idUser);
        $user->status = 1;
        $user->save();
    }
}
