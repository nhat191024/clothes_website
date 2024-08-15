<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\ProductDetail;
use Illuminate\Support\Facades\Auth;

class CartSessionService
{
    private $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function getCart()
    {
        $cart = session('cart');
        return $cart ?? collect();
    }

    public function storeCart($data)
    {
    $cart = session()->get('cart', []);
    $productDetail = $this->cartService->getProductDetail($data['product_id'], $data['color_id'], $data['size_id']);
    if ($productDetail == null){
        return;
    }
    foreach($cart as $item) {
        if($item['product_detail_id'] == $productDetail->id) {
         return $this->updateQuantity($productDetail->id, $data['quantity'] + $item['quantity']);
        }
    }
    $cart[$productDetail->id] = [
        'product_detail_id' => $productDetail->id,
        'user_id' => null,
        'quantity' => $data['quantity'],
        'price' => $data['price'],
        'productDetail' => $productDetail
    ];
    session()->put('cart', $cart);
    }

    public function removeProductByDetailId($productDetailId)
    {
        $cart = session()->get('cart', []);
        if(isset($cart[$productDetailId])) {
            unset($cart[$productDetailId]);
            session()->put('cart', $cart);
        }
        return 'ok';
    }

    public function updateQuantity($productDetailId, $quantity)
    {
        $cart = session()->get('cart', collect([]));
        if ($cart->has($productDetailId)) {
            $cart->put($productDetailId, array_merge($cart->get($productDetailId), ['quantity' => $quantity]));
            session()->put('cart', $cart);
        }
        return [
            'subtotal' => $cart->sum(function ($item) {
                return $item['productDetail']->product->price * $item['quantity'];
            }),
            'total' => $cart->sum(function ($item) {
                return $item['productDetail']->product->price * $item['quantity'];
            }),
        ];
    }
    public function updateProduct($productDetailId, $quantityChange)
    {
        $productDetail = ProductDetail::find($productDetailId);
        $quantity = $this->getCart()->where('product_detail_id', $productDetailId)->first()->quantity + $quantityChange;
        $this->updateQuantity($productDetail->id, $quantity);
    }

    public function migrateCartSessionToCurrentUser()
    {
        if(!Auth::check()) {
            return;
        }
        $cart = session()->get('cart', []);
        foreach($cart as $item) {
            Cart::create(
                [
                    'product_detail_id' => $item['product_detail_id'],
                    'user_id' => Auth::user()->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]
            );
        }
    }

    public function clearCart()
    {
        session()->forget('cart');
    }
}

