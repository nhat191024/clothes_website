<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\LoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $loginService;
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    public function index(){
        if(Auth::check()){
            return redirect()->route('client.home.index');
        }
        return view('client.login.login');
    }

    public function login(Request $request){
        return $this->loginService->loginAuth($request);
    }

    public function logout(Request $request){
        return $this->loginService->logout($request);
    }
}


