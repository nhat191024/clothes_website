<?php

namespace App\Service\client;

use App\Models\Product;

class HomeService
{
    public function getAll()
    {
        return Product::all();
    }
}
