<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Service\admin\AdminLoginService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    private $loginService;
    public function __construct(AdminLoginService $loginService)
    {
        $this->loginService = $loginService;
    }
    public function index(){
        return view('client.login.login');
    }

    public function login(Request $request){
        return $this->loginService->adminLoginAuth($request);
    }

    public function logout(Request $request){
        return $this->loginService->adminLogout($request);
    }
}


