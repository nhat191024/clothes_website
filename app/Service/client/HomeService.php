<?php

namespace App\Service\client;

use App\Models\Banner;
use App\Models\BillDetail;
use App\Models\Product;
use App\Models\Promotion;
use App\Models\Voucher;
use Illuminate\Support\Facades\DB;

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
    public function trendProduct()
    {
        return DB::select("
            SELECT 
                p.name, 
                SUM(bd.quantity) AS total_quantity,
                p.price,
                p.sale_price,
                p.created_at,
                p.img
            FROM 
                bill_details bd
            JOIN 
                product_details pd ON bd.product_detail_id = pd.id
            JOIN 
                products p ON pd.product_id = p.id
            GROUP BY 
                pd.product_id, p.name, p.price, p.sale_price, p.created_at, p.img
            ORDER BY 
                total_quantity DESC
            LIMIT 6;
        ");
    }
    public function favoriteProduct()
    {
        return DB::select("
        SELECT 
            p.name, 
            SUM(bd.quantity) AS total_quantity,
            p.price,
            p.sale_price,
            p.created_at,
            p.img
        FROM 
            bill_details bd
        JOIN 
            product_details pd ON bd.product_detail_id = pd.id
        JOIN 
            products p ON pd.product_id = p.id
        GROUP BY 
            pd.product_id, p.name, p.price, p.sale_price, p.created_at, p.img
        ORDER BY 
            total_quantity ASC
        LIMIT 3;
    ");
    }
    public function latestPromotion()
    {
        return Promotion::orderBy('created_at', 'desc')->first();
    }
    public function productAmount()
    {
        return DB::select("
            SELECT
                c.id AS id,
                LOWER(c.name) AS name,
                c.image AS img,
                COUNT(p.id) AS product_amount
            FROM
                product_categories pc
            JOIN
                categories c ON pc.category_id = c.id
            JOIN
                products p ON pc.product_id = p.id
            GROUP BY
                c.id, c.name, c.image
            ORDER BY
                category_id
            LIMIT 5;

        ");
    }
    public function collectionBanner()
    {
        return Banner::get();
    }
}
