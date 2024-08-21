<?php

namespace App\Service\client;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;

class HomeService
{
    public function newProducts()
    {
        return Product::with('categories')->orderBy('created_at', 'desc')->take(8)->get();
    }

    public function getRandomProduct()
    {
        return Product::inRandomOrder()->take(9)->get();
    }

    public function latestPromotion()
    {
        return Promotion::orderBy('created_at', 'desc')->first();
    }

    public function categoryWithNumberOfProducts()
    {
        return Category::take(5)->withCount('products')->get();
    }

    public function getBanners()
    {
        return Banner::all();
    }
}
