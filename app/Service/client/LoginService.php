<?php

namespace App\Service\client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginService
{
    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('client.home.index');
    }

    public function loginAuth(Request $request)
    {
        $request->validate(
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'username.required' => 'Username, email, SĐT không được để trống!',
                'password.required' => 'Mật khẩu không được để trống!'
            ]
        );

        $usernameInput = $request->input('username');
        $typeOfInputValue = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email'
            : (is_numeric($usernameInput) ? 'phone' : 'username');

        $loginData = [
            $typeOfInputValue => $usernameInput,
            'password' => $request->input('password')
        ];

        if (!Auth::attempt($loginData)) {
            return redirect()->route('client.login.index')->with('message', 'Thông tin không hợp lệ!');
        }
        /** @var \App\Models\User $user **/  $user = Auth::user();
        if ($user->status == 0) {
            return redirect()->route('client.login.index')->with('message', 'Người dùng đã bị khoá!');
        }
        return redirect()->intended(route('client.home.index'));
    }
}

