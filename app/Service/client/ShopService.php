<?php

namespace App\Service\client;

// use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
// use App\Models\Color;
// use App\Models\Size;
use App\Models\Product;
use App\Models\Size;
// use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class ShopService
{
    public function getAllPaginatedProducts($countPerPage)
    {
        return Product::paginate($countPerPage);
    }
    public function getAllProducts()
    {
        return Product::all();
    }

    public function getProductById($id)
    {
        return Product::find($id);
    }
    public function getAllCategories()
    {
        return Category::all();
    }
    public function getAllSizes()
    {
        return Size::all();
    }

    public function getAllColors()
    {
        return Color::all();
    }

    public function getProductsByFilters($categoryIds, $colorIds, $sizeIds, $maxPrice, $minPrice)
    {
        $mainQuery = Product::query();

        if ($categoryIds !== null) {
            foreach ($categoryIds as $categoryId) {
                $mainQuery->whereHas('categories', function ($query) use ($categoryId) {
                    $query->where('category_id', $categoryId);
                });
            }
        }

        $colorIds == null ? true :  $mainQuery->whereHas('productDetail', function ($query) use ($colorIds) {
            $query->whereIn('color_id', $colorIds);
        });

        $sizeIds == null ? true : $mainQuery->whereHas('productDetail', function ($query) use ($sizeIds) {
            $query->whereIn('size_id', $sizeIds);
        });

        $maxPrice == null ? true : $mainQuery->where('price', '<=', $maxPrice);

        $minPrice == null ? true : $mainQuery->where('price', '>=', $minPrice);

        return $mainQuery->paginate(18);
    }
}
