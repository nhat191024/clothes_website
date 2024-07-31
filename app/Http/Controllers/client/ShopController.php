<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Service\client\ShopService;
// use Clockwork\Request\Request;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    private $shopService;
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }
    public function index()
    {
        $allProducts = $this->shopService->getAllProducts();
        return view('client.shop.index', compact('allProducts'));
    }
    public function filterProducts(Request $request)
    {
        $filtered = $this->shopService->getProductsByFilters(
            $request->category,
            $request->color,
            $request->size,
            $request->maxPrice,
            $request->minPrice,
        );
        return response()->json($filtered, 200);
    }
}
