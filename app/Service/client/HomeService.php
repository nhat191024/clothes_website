<?php

namespace App\Service\client;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function newProducts()
    {
        return Product::with('categories')->orderBy('created_at', 'desc')->take(8)->get();
    }

    public function getPaidProducts($count)
    {
        return Product::whereHas('productDetail', function ($query) {
            $query->whereHas('billDetail');
        })->take($count)->get();
    }

    public function trendProduct()
    {
        return $this->getPaidProducts(6);
    }

    public function favoriteProduct()
    {
        return $this->getPaidProducts(3);
    }

    public function latestPromotion()
    {
        return Promotion::orderBy('created_at', 'desc')->first();
    }

    public function productAmount()
    {
        $categories = Category::with('products')->take(5)->get();
        return $categories;
    }

    public function collectionBanner()
    {
        return Banner::get();
    }
}
