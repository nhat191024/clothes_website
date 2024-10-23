<?php

namespace App\Service\client;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginService
{
    public function loginAuth(Request $request)
    {
        $userLogin = $this->userLoginAuth($request);
        $adminLogin = $this->adminLoginAuth($request);
        if ($userLogin) {
            /** @var User $user **/  $user = Auth::user();
            if ($user->status == 0) {
                return redirect()->route('login')->with('message', 'Your account has been locked!');
            }
            return redirect()->intended(route('client.home.index'));
        }
        if ($adminLogin) {
            $user = Auth::guard('admin')->user();
            if ($user->status == 0) {
                return redirect()->route('login')->with('message', 'Your account has been locked!');
            }
            return redirect()->intended(route('admin.home.index'));
        }
        return redirect()->route('login')->with('message','Wrong username or password!');
    }
    public function userLogout(Request $request)
    {
        Auth::guard('web')->logout();
        return redirect()->route('client.home.index');
    }

    public function userLoginAuth(Request $request)
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

        return Auth::attempt($loginData);
    }

    private function adminSessionLogout(Request $request)
    {
        Auth::guard('admin')->logout();
    }

    public function adminLogout(Request $request)
    {
        $this->adminSessionLogout($request);
        return redirect()->route('login');
    }

    public function adminLoginAuth(Request $request)
    {
        $loginData = $this->getAdminLoginData($request);
        return Auth::guard('admin')->attempt($loginData);
    }

    private function getAdminLoginData(Request $request)
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