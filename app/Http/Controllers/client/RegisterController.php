<?php

namespace App\Http\Controllers\client;

use App\Service\client\RegisterService;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;

class RegisterController extends Controller
{
    private  $register;
    public function __construct()
    {
        $this->register = new RegisterService();
    }
    public function index(){
        return view('client.register.register');
    }
    public function create(RegisterRequest $request){
        return $this->register->registerAuth($request);
    }
}
