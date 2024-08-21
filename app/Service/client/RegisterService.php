<?php

namespace App\Service\client;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RegisterService {
    
    public function registerAuth(RegisterRequest $request){

        $user = User::create([
            'username' =>$request->username,
            'full_name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
            'avt' => 'avt-default.png',
        ]);
        Auth::login($user);
        return redirect()->route('client.home.index');
    }
}
?>