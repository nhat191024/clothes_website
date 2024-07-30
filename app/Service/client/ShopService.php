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
    public function getProductsByFilters($parentCategoryId, $childCategoryId, $colorIds, $sizeIds, $maxPrice, $minPrice)
    {
        $MainQuery = Product::query();
        $parentCategoryId == null ? true : $MainQuery->whereHas('productCategory', function ($query) use ($parentCategoryId) {
            $query->where('product_categories.category_id', $parentCategoryId);
        });
        $childCategoryId == null ? true : $MainQuery->whereHas('productCategory', function ($query) use ($childCategoryId) {
            $query->where('product_categories.category_id', $childCategoryId);
        });
        $colorIds == null ? true : $MainQuery->whereHas('productDetail', function ($query) use ($colorIds) {
            $query->whereIn('color_id', $colorIds);
        });
        $sizeIds == null ? true : $MainQuery->whereHas('productDetail', function ($query) use ($sizeIds) {
            $query->whereIn('size_id', $sizeIds);
        });
        $maxPrice == null && $minPrice == null ? true : $MainQuery->where('price', '>=', 0) && $MainQuery->where('price', '<=', 200000);
        return $MainQuery->paginate(9);
    }
    public function getMaxPrice()
    {
        return Product::max('price');
    }
    public function getMinPrice()
    {
        return Product::min('price');
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
