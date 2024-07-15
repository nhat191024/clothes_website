<?php

namespace App\Service\client;

use App\Models\BillDetail;
use App\Models\Product;
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
}
