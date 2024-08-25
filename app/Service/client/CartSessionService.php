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
    private $promoService;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
        $this->voucherService = app(VoucherService::class);
        $this->promoService = app(PromotionService::class);
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
        if ($productDetail == null)
            return [
            'status' => 404,
            'success' => false
            ];

        if ($cart) {
            foreach ($cart as $item) {
                if ($item['product_detail_id'] == $productDetail->id) {
                    return $this->updateQuantity($productDetail->id, $data['quantity'] + $item['quantity']);
                }
            }
        }
        $productPrice = $this->promoService->getProductPriceThatHasPromotion($productDetail->product_id);
        $cart[$productDetail->id] = [
            'product_detail_id' => $productDetail->id,
            'name' => $data['name'],
            'quantity' => $data['quantity'],
            'price' => $productPrice,
            'productDetail' => $productDetail
        ];
        session()->put('cart', $cart);
        return [
            'status' => 200,
            'success' => false
        ];
    }

    public function removeProductByDetailId($productDetailId)
    {
        $cart = $this->getCart();
        if (isset($cart[$productDetailId])) {
            unset($cart[$productDetailId]);
            session()->put('cart', $cart);
        }
        $this->voucherService->getActivatedVoucher($this->getSubTotal());
        return ['subtotal'=>$this->getSubtotal()];
    }

    public function updateQuantity($productDetailId, $quantity)
    {
        $cart = $this->getCart();
        $productPrice = $this->promoService->getProductPriceThatHasPromotionByDetailId($productDetailId);
        if ($cart[$productDetailId]??['product_detail_id'] == $productDetailId) {
            if ($cart instanceof \Illuminate\Support\Collection) {
                $cart->put($productDetailId, array_merge($cart->get($productDetailId),
                [
                    'quantity' => $quantity,
                    'price'=> $productPrice
                ]
            ));
            } else {
                $cart[$productDetailId]['quantity'] = $quantity;
                $cart[$productDetailId]['price'] = $productPrice;
            }
            session()->put('cart', $cart instanceof \Illuminate\Support\Collection ? $cart->toArray() : $cart);
        }
        $cart = collect($cart);
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

    public function getCartCount()
    {
        $cart = $this->getCart();
        if ($cart instanceof \Illuminate\Support\Collection) {
            return $cart->sum('quantity');
        } else {
            return array_reduce($cart, function ($sum, $item) {
                return $sum + $item['quantity'];
            }, 0);
        }
    }
}
