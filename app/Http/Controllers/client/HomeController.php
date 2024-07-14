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
    public function NewProductsInfo()
    {
        $newProductInfo = $this->homeService->newProducts();
        return view('client.home.index', compact('newProductInfo'));
    }
}
