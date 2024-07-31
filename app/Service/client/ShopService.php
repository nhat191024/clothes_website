<?php

namespace App\Service\client;

// use App\Models\Banner;
use App\Models\Category;
// use App\Models\Color;
// use App\Models\Size;
use App\Models\Product;
// use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class ShopService
{
    public function getAllProducts()
    {
        return Product::paginate(9);
    }

    public function getProductsByFilters($categoryIds, $colorIds, $sizeIds, $maxPrice, $minPrice)
    {
        $mainQuery = Product::query();

        $categoryIds == null ? true : $mainQuery->whereHas('categories', function ($query) use ($categoryIds) {
            $query->where('category_id', $categoryIds);
        });

        $colorIds == null ? true :  $mainQuery->whereHas('productDetail', function ($query) use ($colorIds) {
            $query->whereIn('color_id', $colorIds);
        });

        $sizeIds == null ? true : $mainQuery->whereHas('productDetail', function ($query) use ($sizeIds) {
            $query->whereIn('size_id', $sizeIds);
        });

        $maxPrice == null ? true : $mainQuery->where('price', '>=', 0);

        $minPrice == null ? true : $mainQuery->where('price', '<=', 0);

        return $mainQuery->paginate(9);
    }
}
