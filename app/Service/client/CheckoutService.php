<?php

namespace App\Service\client;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Service\client\CartService;
use App\Service\client\CartSessionService;
use App\Service\client\VoucherService;
use App\Service\MailService;
use App\Service\PointService;
use Illuminate\Support\Facades\Auth;

class CheckoutService
{
    private $cartService;
    private $cartSessionService;
    private $voucherService;
    private $mailService;
    private $pointService;

    private $carts;

    public function __construct()
    {
        $this->cartService = new CartService();
        $this->cartSessionService = new CartSessionService();
        $this->mailService = new MailService();
        $this->voucherService = new VoucherService();
        $this->pointService = app(PointService::class);

        $this->carts = $this->cartService->getCart();
        if ($this->carts == null) $this->carts = $this->cartSessionService->getCart();
    }

    public function getProductList()
    {
        return $this->carts;
    }

    public function getDiscount()
    {
        $voucher = $this->voucherService->getDiscountAmount($this->getCartSubTotal());
        return $voucher;
    }

    public function getCartSubTotal()
    {
        $total = 0;
        foreach ($this->carts as $cart) {
            $total += $cart['price'] * $cart['quantity'];
        }
        return $total;
    }

    public function getCartTotal()
    {
        $total = $this->getCartSubTotal();
        $discount = $this->getDiscount();
        return $total - $discount;
    }

    public function confirmOrder($request)
    {
        $user = Auth::user();
        $total = $this->getCartTotal();
        $pointUsed = 0;
        $usingPoint = $request->usingPoint;
        $buildingName = $request->buildingName === 'null' ? '' : ', ' . $request->buildingName;
        $address = $request->prefecture . ', ' . $request->city . ', ' . $request->address . $buildingName;

        $user ? $response =  $this->pointService->payWithPoint($user, $total, $usingPoint) : $response = null;
        $response ? $pointUsed = $response['pointUsed']  : $pointUsed = 0;

        $bill = Bill::create([
            'user_id' => $user ? $user->id : null,
            'full_name' => $request->fullName,
            'address' => $address,
            'phone' => $request->phoneNumber,
            'email' => $request->email,
            'delivery_method' => $request->delivery,
            'payment_method' => $request->payment,
            'points_for_user' => 0,
            'points_use_for_payment' => $pointUsed,
            'total' => $total,
        ]);

        // $this->mailService->adminSend(
        //     'richberchannel01@gmail.com',
        //     $request->fullName,
        //     $bill->id,
        //     $request->email,
        //     $request->phoneNumber,
        //     $address,
        //     $request->payment,
        //     $request->delivery,
        //     $bill->created_at,
        //     $this->getCartSubTotal(),
        //     $this->getDiscount(),
        //     $total
        // );

        // $this->mailService->customerSend(
        //     $request->email,
        //     $request->fullName,
        //     $bill->id,
        //     $request->email,
        //     $request->phoneNumber,
        //     $address,
        //     $request->payment,
        //     $request->delivery,
        //     $bill->created_at,
        //     $this->getCartSubTotal(),
        //     $this->getDiscount(),
        //     $total
        // );

        foreach ($this->carts as $cart) {
            BillDetail::create([
                'bill_id' => $bill->id,
                'product_id' => $cart['productDetail']->product->id,
                'color_id' => $cart['productDetail']->color->id,
                'size_id' => $cart['productDetail']->size->id,
                'quantity' => $cart['quantity'],
                'price' => $cart['price'],
            ]);

            $user ? $this->cartService->removeProductByDetailId($cart['product_detail_id']) : $this->cartSessionService->removeProductByDetailId($cart['product_detail_id']);
        }

        $this->voucherService->clearVoucher();
        $this->voucherService->setAsUsed();

        return response()->json([
            'status' => 200,
            'message' => 'success'
        ]);
    }
}
