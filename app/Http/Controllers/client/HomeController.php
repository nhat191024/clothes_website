<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\HomeService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    private $homeService;
    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }
    public function index()
    {
        $homeServiceInfo = $this->homeService->getAll();
        dd($homeServiceInfo);
    }
}
