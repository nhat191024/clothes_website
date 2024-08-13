<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;

class CartService
{

    public function getCart()
    {
        $user = Auth::user();
        if ($user) {
            return Cart::where('user_id', $user->id)->get();
        }
        return $this->getCartSession();
    }

    public function storeCart($data)
    {
        $productDetail = $this->getProductDetail($data['product_id'], $data['color_id'], $data['size_id']);
        $cartUser = Cart::where('product_detail_id', $productDetail->id)->where('user_id', Auth::user()->id);
        $isDuplicate = $cartUser->exists();
        if($isDuplicate){
            return $this->updateQuantity($productDetail->id, $data['quantity'] + $cartUser->first()->quantity);
        }
        Cart::create(
            [
                'product_detail_id' => $productDetail->id,
                'user_id' => Auth::user()->id,
                'quantity' => $data['quantity'],
                'price' => $data['price'],
            ]
        );
        return [
            'status' => 200,
            'success' => true
        ];
    }

    public function getProductDetail($productId, $colorId, $sizeId)
    {
        return ProductDetail::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->first();
    }

    public function removeProductByDetailId($productDetailId)
    {
        Cart::where('product_detail_id', $productDetailId)->delete();
        return 'ok';
    }

    public function updateQuantity($productDetailId, $quantity)
    {
        Cart::where('product_detail_id', $productDetailId)->update([
            'quantity' => $quantity
        ]);
        return 'ok';
    }

    public function getCartSession()
    {
        return null;
    }
}
