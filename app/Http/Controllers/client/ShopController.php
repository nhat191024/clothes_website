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
    public function index(Request $request)
    {
        //categories
        $parentCategory = $this->shopService->getParentCategory();
        $childCategory = $this->shopService->getChildCategory();
        $colors = $this->shopService->getColor();
        $sizes = $this->shopService->getSize();
        //
        $allProducts = $this->shopService->getProductsByFilters(null, null, null, null, null);
        // dd($childCategory);
        return view('client.shop.index', compact('allProducts', 'parentCategory', 'childCategory', 'colors', 'sizes'));
    }
}
