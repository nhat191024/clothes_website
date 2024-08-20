<?php

namespace App\Service\admin;

use App\Models\UserAdmin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminLoginService
{

    public function sessionLogout(Request $request)
    {
        Auth::guard('admin')->logout();
    }

    public function adminLogout(Request $request)
    {
        $this->sessionLogout($request);
        return redirect()->route('login');
    }

    public function adminLoginAuth(Request $request)
    {
        $loginData = $this->getLoginData($request);

        if (!Auth::guard('admin')->attempt($loginData)) {
            return redirect()->route('login')->with('message', 'Thông tin không hợp lệ!');
        }
        $user = Auth::guard('admin')->user();
        if ($user->status == 0) {
            return redirect()->route('login')->with('message', 'Người dùng đã bị khoá!');
        }
        return redirect()->intended(route('admin.home.index'));
    }

    public function getLoginData(Request $request)
    {
        $request->validate(
            [
                'username' => ['required', 'string'],
                'password' => ['required', 'string'],
            ],
            [
                'username.required' => 'Username, email không được để trống!',
                'password.required' => 'Mật khẩu không được để trống!'
            ]
        );
        $usernameInput = $request->input('username');
        $typeOfInputValue = filter_var($usernameInput, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $loginData = [
            $typeOfInputValue => $usernameInput,
            'password' => $request->input('password')
        ];
        return $loginData;
    }
}
