<?php

namespace App\Service\admin;

use App\Models\Cart;
use App\Models\Food;
use App\Models\Product_variation;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductDetail;

class ProductService
{
    public function getAll()
    {
        $product = Product::withTrashed()
            ->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('created_at', 'desc')
            ->get();
        return $product;
    }

    public function getById($id)
    {
        return Product::where('id', $id)->first();
    }

    public function getProductDetails($productId)
    {
        // Lấy thông tin sản phẩm cơ bản
        $product = Product::with(['productDetail.size', 'productDetail.color'])->find($productId);
        // Chuyển đổi dữ liệu thành cấu trúc mong muốn
        return $productDetails = (object) [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->img,
            'categories' => $product->categories->pluck('id')->toArray(), // Giả sử bạn có relationship `categories` để lấy các danh mục của sản phẩm
            'sizes' => $product->productDetail->groupBy('size_id')->map(function ($productDetail, $sizeId) {
                return [
                    'size' => $sizeId,
                    'colors' => $productDetail->pluck('color_id')->toArray()
                ];
            })->values()->toArray()
        ];
    }

    public function add($categoryArray, $productName, $productPrice, $productDescription, $imageName, $sizeColors)
    {
        $id = Product::create([
            'name' => $productName,
            'description' => $productDescription,
            'img' => $imageName,
            'price' => $productPrice
        ])->id;

        foreach ($categoryArray as $item) {
            ProductCategory::create([
                'product_id' => $id,
                'category_id' => $item
            ]);
        }

        foreach ($sizeColors as $sizeColor) {
            $size = $sizeColor['size'];
            foreach ($sizeColor['colors'] as $item) {
                ProductDetail::create([
                    'product_id' => $id,
                    'size_id' => $size,
                    'color_id' => $item
                ]);
            }
        }
        return $id;
    }

    public function edit($id, $categoryArray, $productName, $productPrice, $productDescription, $imageName, $sizeColors)
    {

        $cartItems = Cart::where('product_detail_id', $id)->get();
        $cartItems->each->delete();

        Product::find($id)->update([
            'name' => $productName,
            'description' => $productDescription,
            'img' => $imageName,
            'price' => $productPrice
        ]);

        ProductCategory::where('product_id', $id)->delete();

        foreach ($categoryArray as $item) {
            ProductCategory::create([
                'product_id' => $id,
                'category_id' => $item
            ]);
        }

        ProductDetail::where('product_id', $id)->forceDelete();

        foreach ($sizeColors as $sizeColor) {
            $size = $sizeColor['size'];
            foreach ($sizeColor['colors'] as $item) {
                ProductDetail::create([
                    'product_id' => $id,
                    'size_id' => $size,
                    'color_id' => $item
                ]);
            }
        }

        $cartItems->each(function ($item) {
            $item->update([
                'product_detail_id' => $item->id
            ]);
        });
        return $id;
    }

    public function delete($id)
    {
        $product = Product::find($id);
        if ($product) {
            $product->delete(); // Thực hiện xóa mềm
        }
    }

    public function restore($id)
    {
        $product = Product::withTrashed()->find($id);
        if ($product) {
            $product->restore(); // Khôi phục sản phẩm
        }
    }
}
