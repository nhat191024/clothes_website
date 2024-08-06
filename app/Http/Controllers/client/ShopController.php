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
        $allPageProducts = $this->shopService->getAllPaginatedProducts(9);
        $allProducts = $this->shopService->getAllProducts();
        $allCategories = $this->shopService->getAllCategories();
        $allSizes = $this->shopService->getAllSizes();
        $allColors = $this->shopService->getAllColors();
        return view('client.shop.index', compact('allPageProducts','allProducts','allCategories','allSizes','allColors'));
    }
    public function filterProducts(Request $request)
    {
        $filtered = $this->shopService->getProductsByFilters(
            $request->category,
            $request->color,
            $request->size,
            $request->max,
            $request->min,
        );
        return response()->json($filtered, 200);
    }
    public function detailProduct($id)
    {
        $product = $this->shopService->getProductById($id);
        return view('client.shop.detail', compact('product'));
        // return $product;
    }
}
