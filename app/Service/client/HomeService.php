<?php

namespace App\Service\client;

use App\Models\Product;

class HomeService
{
    // public function getNewProducts()
    // {
    //     return Product::with('categories')->orderBy('created_at', 'desc')->take(8)->get();
    // }
    public function newProducts()
    {
        return Product::with('categories')->orderBy('created_at', 'desc')->take(8)->get();
    }
}
