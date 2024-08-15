<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private $voucherService;
    public function __construct(VoucherService $voucherService)
    {
        $this->voucherService = $voucherService;
    }

    public function getCart()
    {
        $user = Auth::user();
        return Cart::where('user_id', $user->id)->get();
    }

    public function storeCart($data)
    {
        $productDetail = $this->getProductDetail($data['product_id'], $data['color_id'], $data['size_id']);
        if ($productDetail == null){
            return;
        }
        $cartUser = Cart::where('product_detail_id', $productDetail->id)->where('user_id', Auth::user()->id);
        $isDuplicate = $cartUser->exists();
        if($isDuplicate){
            return $this->updateQuantity($productDetail->id, $data['quantity'] + $cartUser->first()->quantity);
        }
        $productPrice = $productDetail->product->price;
        Cart::create(
            [
                'product_detail_id' => $productDetail->id,
                'user_id' => Auth::user()->id,
                'quantity' => $data['quantity'],
                'price' => $productPrice,
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
        return [
            'subtotal' => $this->getCart()->sum(function ($item) {
                return $item->productDetail->product->price * $item->quantity;
            }),
            'total' => $this->getCart()->sum(function ($item) {
                return $item->productDetail->product->price * $item->quantity;
            }),
        ];
    }
    public function updateProduct($productDetailId, $quantityChange)
    {
        $productDetail = ProductDetail::find($productDetailId);
        $quantity = $this->getCart()->where('product_detail_id', $productDetailId)->first()->quantity + $quantityChange;
        $this->updateQuantity($productDetail->id, $quantity);
    }

    public function getSubtotal()
    {
        return $this->getCart()->sum(function ($item) {
            return $item->productDetail->product->price * $item->quantity;
        });
    }
}
