<?php

namespace App\Service\client;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterService {

    public function registerAuth(RegisterRequest $request){
        $request->validate([
            'username' => 'required|unique:users,username',
            'name' => 'required',
            'phone' => ['required', 'regex:/^\d{2}(?:-\d{4}-\d{4}|\d{8}|\d-\d{3,4}-\d{4})$/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        $user = User::create([
            'username' =>$request->username,
            'full_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
            'avt' => 'avt-default.png',
        ]);
        Auth::login($user);
        return redirect()->route('client.account.index')->with('message', 'Registration Successfully!');
    }
}
?>
