<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Service\client\VoucherService;
use App\Service\client\PromotionService;
use Illuminate\Support\Facades\Auth;

class CartService
{
    private $voucherService;
    private $promoService;

    public function __construct()
    {
        $this->voucherService = app(VoucherService::class);
        $this->promoService = app(PromotionService::class);
    }

    public function getCart()
    {
        $user = Auth::user();
        if ($user == null) return null;
        return Cart::where('user_id', $user->id)->get();
    }

    public function storeCart($data)
    {
        $productDetail = $this->getProductDetail($data['product_id'], $data['color_id'], $data['size_id']);
        if ($productDetail == null){
            return [
                'status' => 404,
                'success' => false
            ];
        }
        $cartUser = Cart::where('product_detail_id', $productDetail->id)->where('user_id', Auth::user()->id);
        $isDuplicate = $cartUser->exists();
        if($isDuplicate){
            return $this->updateQuantity($productDetail->id, $data['quantity'] + $cartUser->first()->quantity);
        }
        $productPrice = $this->promoService->getProductPriceThatHasPromotionByDetailId($productDetail->id);
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
            'success' => false
        ];
    }


    public function getProductDetail($productId, $colorId, $sizeId)
    {
        return ProductDetail::where('product_id', $productId)
            ->where('color_id', $colorId)
            ->where('size_id', $sizeId)
            ->with('color', 'size')
            ->first();
    }

    public function removeProductByDetailId($productDetailId)
    {
        Cart::where('product_detail_id', $productDetailId)->delete();
        return ['subtotal'=>$this->getSubtotal()];
    }

    public function updateQuantity($productDetailId, $quantity)
    {
        $productDetail = ProductDetail::find($productDetailId);
        $productPrice = $this->promoService->getProductPriceThatHasPromotionByDetailId($productDetail->id);
        Cart::where('product_detail_id', $productDetailId)->update([
            'quantity' => $quantity,
            'price'=> $productPrice
        ]);
        $subTotal = $this->getSubTotal();
        $discount = $this->voucherService->getDiscountAmount($subTotal);
        return [
            'discount' => $discount,
            'subtotal' => $subTotal,
            'total' => $subTotal - $discount
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
            return $item->price * $item->quantity;
        });
    }

    public function clearCart()
    {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    public function getCartCount()
    {
        return Cart::where('user_id', Auth::user()->id)->sum('quantity');
    }
}
