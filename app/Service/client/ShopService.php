<?php

namespace App\Service\client;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Product;
use App\Models\Promotion;
use Illuminate\Support\Facades\DB;

class ShopService
{
    public function getProductsByFilters($categoryId, $colorId, $sizeId, $maxPrice, $minPrice)
    {
        $MainQuery = Product::query();
        $categoryId == null ? true : $MainQuery->whereHas('productCategory', function ($query) use ($categoryId) {
            $query->where('product_categories.category_id', $categoryId);
        });
        $colorId == null ? true : $MainQuery->whereHas('productDetail', function ($query) use ($colorId) {
            $query->where('color_id', $colorId);
        });
        $sizeId == null ? true : $MainQuery->whereHas('productDetail', function ($query) use ($sizeId) {
            $query->where('size_id', $sizeId);
        });
        $maxPrice == null && $minPrice == null ? true : $MainQuery->where('price', '>=', 0) && $MainQuery->where('price', '<=', 200000);
        return $MainQuery->paginate(9);
    }
    public function getParentCategory()
    {
        return Category::orderBy('id', 'asc')->take(3)->get();
    }
    public function getChildCategory()
    {
        return Category::orderBy('id', 'desc')->take(Category::count() - 3)->get();
    }
    public function getColor()
    {
        return Color::get();
    }
    public function getSize()
    {
        return Size::get();
    }
}
