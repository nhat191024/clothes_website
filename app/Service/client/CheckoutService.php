<?php

namespace App\Service\client;

use App\Models\Cart;
use App\Models\User;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Service\client\CartService;
use App\Service\MailService;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    private $cartService;
    private $mailService;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->mailService = new MailService();
    }

    public function getProductList()
    {
        $carts = $this->cartService->getCart();
        return $carts;
    }

    public function getCartTotal()
    {
        $carts = $this->cartService->getCart();
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->price * $cart->quantity;
        }
        return $total;
    }

    public function confirmOrder($request)
    {
        $user = Auth::user();
        $total = $this->getCartTotal();
        $point = $total / 100;
        $buildingName = $request->buildingName === 'null' ? '' : ', ' . $request->buildingName;
        $address = $request->prefecture . ', ' . $request->city . ', ' . $request->address . $buildingName;
        User::where('id', $user->id)->update([
            'point' => $user->point + $point
        ]);

        $bill = Bill::create([
            'full_name' => $request->fullName,
            'address' => $address,
            'phone' => $request->phoneNumber,
            'email' => $request->email,
            'delivery_method' => $request->delivery,
            'payment_method' => $request->payment,
            'point' => $point,
            'total_amount' => $total,
        ]);

        $this->mailService->adminSend(
            'richberchannel01@gmail.com',
            $request->fullName,
            $bill->id,
            $request->email,
            $request->phoneNumber,
            $address,
            $request->payment,
            $request->delivery,
            $bill->created_at,
            0,
            $total
        );

        $this->mailService->customerSend(
            $request->email,
            $request->fullName,
            $bill->id,
            $request->email,
            $request->phoneNumber,
            $address,
            $request->payment,
            $request->delivery,
            $bill->created_at,
            0,
            $total
        );

        $carts = $this->getProductList();
        foreach ($carts as $cart) {
            BillDetail::create([
                'bill_id' => $bill->id,
                'product_id' => $cart->productDetail->product->id,
                'color_id' => $cart->productDetail->color->id,
                'size_id' => $cart->productDetail->size->id,
                'quantity' => $cart->quantity,
                'price' => $cart->price,
            ]);
            $this->cartService->removeProductByDetailId($cart->product_detail_id);
        }

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }
}
