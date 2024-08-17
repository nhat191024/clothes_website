<?php

namespace App\Service\client;

use App\Models\Product;
use App\Models\ProductDetail;

class ProductService
{
    public function getColorsOfSizesByProductId($id)
    {
        $result = collect();
        $productDetails = $this->getSizesByProductId($id);
        foreach ($productDetails as $size) {
            $colors = $this->getColorsBySizeIdAndProductId($size->size_id, $id);
            $toPush = collect([
                "size_id" => $size->size_id,
                "colors" => $colors
            ]);
            $result->push($toPush);
        }
        return response()->json($result, 200);
    }

    private function getSizesByProductId($id)
    {
        return ProductDetail::where('product_id', $id)->get();
    }

    private function getColorsBySizeIdAndProductId($size_id, $product_id)
    {
        return ProductDetail::where('product_id', $product_id)->where('size_id', $size_id)->distinct('color_id')->get('color_id');
    }
}
