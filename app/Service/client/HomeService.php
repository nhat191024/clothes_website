<?php

namespace App\Service\client;

use App\Models\Banner;
use App\Models\BillDetail;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Promotion;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

class HomeService
{
    public function newProducts()
    {
        return Product::with('categories')->orderBy('created_at', 'desc')->take(8)->get();
    }
    public function getPaidProducts($count)
    {
        return Product::select(
            'products.id',
            'products.name',
            DB::raw('COUNT(bill_details.id) as total_quantity'),
            'products.price',
            'products.sale_price',
            'products.created_at',
            'products.img'
        )
            ->join('product_details', 'products.id', '=', 'product_details.product_id')
            ->join('bill_details', 'product_details.id', '=', 'bill_details.product_detail_id')
            ->groupBy('products.id', 'products.name', 'products.price', 'products.sale_price', 'products.created_at', 'products.img')
            ->take($count)
            ->get();
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
        $productAmount = [];
        $categories = Category::with('product')->take(5)->get();
        foreach ($categories as $ct) {
            $productAmount[] = [
                'id' => $ct->id,
                'name' => strtolower($ct->name),
                'img' => $ct->image,
                'product_amount' => $ct->product->count()
            ];
        }
        return $productAmount;
    }
    public function collectionBanner()
    {
        return Banner::get();
    }
}
