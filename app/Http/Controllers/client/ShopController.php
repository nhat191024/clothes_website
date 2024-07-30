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
        //categories
        $parentCategory = $this->shopService->getParentCategory();
        $childCategory = $this->shopService->getChildCategory();
        $colors = $this->shopService->getColor();
        $sizes = $this->shopService->getSize();
        $maxPrice = $this->shopService->getMaxPrice();
        $minPrice = $this->shopService->getMinPrice();
        //

        // $allProducts = $this->shopService->getProductsByFilters(
        //     $request->input('parentCategory'),
        //     $request->input('childCategory'),
        //     $request->input('colors'),
        //     $request->input('sizes'),
        //     $request->has('maxPrice'),
        //     $request->has('maxPrice')
        // );
        $allProducts = $this->shopService->getProductsByFilters(
            null,
            null,
            null,
            null,
            null,
            null
        );
        dd($allProducts);
        // return view('client.shop.index', compact('allProducts', 'parentCategory', 'childCategory', 'colors', 'sizes', 'minPrice', 'maxPrice'));
    }
    public function filterProducts(Request $request)
    {
        $allProducts = $this->shopService->getProductsByFilters(
            null,
            null,
            null,
            null,
            null,
            null
        );
        return view('client.shop.partials.product-list', compact('allProducts'))->render();
    }
}
