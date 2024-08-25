<?php

namespace App\Service\client;

use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\Promotion;

class PromotionService
{
    public function getDiscountedPriceByProductId($productId)
    {
        $promo = Promotion::where('id',$productId)->with('product')->first();
        $discount_percentage = $promo->discount_percentage;
        if($promo->start_time > now() || $promo->end_time < now())
            return $promo->product->price;
        return $promo->product->price * ($discount_percentage/100);
    }

    public function getProductPriceThatHasPromotion($productId)
    {
        $product = Product::where('id',$productId)->first();
        $discountedPrice = $this->getDiscountedPriceByProductId($productId);
        return $product->price - $discountedPrice;
    }
    public function getProductPriceThatHasPromotionByDetailId($productDetailId)
    {
        $productId = ProductDetail::where('id',$productDetailId)->first()->product->id;
        return $this->getProductPriceThatHasPromotion($productId);
    }
}

