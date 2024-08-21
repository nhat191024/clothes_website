<?php

namespace App\Service\client;

use App\Models\ProductDetail;
class ProductService
{
    public function getColorsOfSizesByProductId($id)
    {
        $productDetails = ProductDetail::with('size', 'color')
            ->where('product_id', $id)
            ->get();

        $result = $productDetails->groupBy('size_id')->map(function ($items) {
            return collect([
                'size_id' => $items->first()->size_id,
                'colors' => $items->pluck('color_id'),
            ]);
        });

        return response()->json($result, 200);
    }
}
