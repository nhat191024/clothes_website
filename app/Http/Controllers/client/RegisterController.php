<?php

namespace App\Http\Controllers\client;

use App\Service\client\RegisterService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    private  $registerService;

    public function __construct()
    {
        $this->registerService = new RegisterService();
    }

    public function index(){
        return view('client.register.register');
    }

    public function create(Request $request){
        return $this->registerService->registerAuth($request);
    }
}
