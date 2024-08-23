<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\CartSessionService;
use App\Service\client\LoginService;
use App\Service\client\VoucherService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    private $loginService;
    private $voucherService;
    private $cartService;

    public function __construct(
        LoginService $loginService,
        VoucherService $voucherService,
        CartSessionService $cartService
    )
    {
        $this->loginService = $loginService;
        $this->voucherService = $voucherService;
        $this->cartService = $cartService;
    }
    public function index(){
        if(Auth::check()){
            return redirect()->route('client.home.index');
        }
        return view('client.login.login');
    }

    public function login(Request $request){
        $result = $this->loginService->loginAuth($request);
        $this->voucherService->clearVoucher();
        return $result;
    }

    public function logout(Request $request){
        $result = $this->loginService->userLogout($request);
        $this->voucherService->clearVoucher();
        $this->cartService->clearCart();
        return $result;
    }
    public function adminLogout(Request $request){
        $result = $this->loginService->adminLogout($request);
        return $result;
    }
}


