<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\ProductDetail;
use App\Service\client\VoucherService;
use App\Service\client\CartService;
use Illuminate\Support\Facades\Auth;

class CartSessionService
{
    private $cartService;
    private $voucherService;

    public function __construct()
    {
        $this->cartService =  new cartService();
        $this->voucherService = new voucherService();
    }

    public function getCart()
    {
        $cart = session('cart');
        return $cart ?? collect([]);
    }

    public function storeCart($data)
    {
        $cart = $this->getCart();
        $productDetail = $this->cartService->getProductDetail($data['product_id'], $data['color_id'], $data['size_id']);
        if ($productDetail == null) return;

        if ($cart) {
            foreach ($cart as $item) {
                if ($item['product_detail_id'] == $productDetail->id) {
                    return $this->updateQuantity($productDetail->id, $data['quantity'] + $item['quantity']);
                }
            }
        }

        $cart[$productDetail->id] = [
            'product_detail_id' => $productDetail->id,
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $productDetail->product->price,
            'productDetail' => $productDetail
        ];
        session()->put('cart', $cart);
    }

    public function removeProductByDetailId($productDetailId)
    {
        $cart = $this->getCart();
        if (isset($cart[$productDetailId])) {
            unset($cart[$productDetailId]);
            session()->put('cart', $cart);
        }
        return 'ok';
    }

    public function updateQuantity($productDetailId, $quantity)
    {
        $cart = $this->getCart();

        if (array_key_exists($productDetailId, $cart)) {
            $cart[$productDetailId]['quantity'] = $quantity;
            session()->put('cart', $cart instanceof \Illuminate\Support\Collection ? $cart->toArray() : $cart);
        }
        $cart = collect($cart);

        return [
            'subtotal' => $cart->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            }),
            'total' => $cart->sum(function ($item) {
                return $item['price'] * $item['quantity'];
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
        if (!Auth::check()) {
            return;
        }
        $cart = $this->getCart();
        foreach ($cart as $item) {
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

    public function getSubtotal()
    {
        $cart = $this->getCart();
        if (!$cart) return 0;
        if ($cart instanceof \Illuminate\Support\Collection) {
            return $cart->sum(function ($item) {
                return $item['price'] * $item['quantity'];
            });
        } else {
            return array_reduce($cart, function ($subtotal, $item) {
                return $subtotal + ($item['price'] * $item['quantity']);
            }, 0);
        }
    }
}
