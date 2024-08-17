<?php

namespace App\Service\client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class RegisterService {
    public function registerAuth(Request $request){
        $request->validate([
            'username' => ['required','max:191','unique:users'],
            'name' => ['required','string','max:191'],
            'phone' => ['required','string','max:191','unique:users'],
            'email' => ['required','string','email','max:191','unique:users'],
            'password' => ['required','string','min:8','confirmed'],
        ],         
        [
            'username.required' => 'Username is required!',
            'username.unique' => 'Username is already taken!',
            'name.required' => 'Name is required!',
            'phone.required' => 'Phone number is required!',
            'phone.unique' => 'Phone number is already taken!',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email is already taken!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters!',
            'password.confirmed' => 'Password confirmation does not match!',
        ]
    );
        $user = User::create([
            'username' =>$request->username,
            'full_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
        ]);
        Auth::login($user);
        return redirect()->route('client.home.index');
    }
}
?>