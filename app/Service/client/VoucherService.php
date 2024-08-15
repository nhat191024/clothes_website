<?php

namespace App\Service\client;
use App\Models\Voucher;

class VoucherService
{
    public function __construct()
    {
        //
    }

    public function clearVoucher()
    {
        session()->forget('voucherCode');
    }

    public function applyVoucher($voucherCode,$subTotal)
    {
        $checkResult = $this->checkVoucher($voucherCode,$subTotal);
        if($checkResult){
            ($checkResult['valid']) ? $this->setActiveVoucherCode($voucherCode): $this->clearVoucher();
            return [
                'subtotal'=>$subTotal,
                'discount'=>$this->getDiscountAmount($subTotal),
                'checkResult'=> $checkResult
            ];
        }
    }

    public function getDiscountAmount($cartSubtotal)
    {
        $voucherCode = session()->get('voucherCode');
        $voucher = Voucher::where('code', $voucherCode)->first();
        if (!$voucher){
            return 0;
        }
        return $cartSubtotal * $voucher->discount_percentage / 100;
    }

    public function getActivatedVoucher($cartSubtotal)
    {
        $voucherCode = session()->get('voucherCode');
        $result = $this->checkVoucher($voucherCode,$cartSubtotal);
        if($result['valid']){
            return $result['voucher'];
        }
        $this->setActiveVoucherCode(null);
        return null;
    }

    private function checkVoucher($voucherCode,$totalPrice)
    {
        $voucher = Voucher::where('code', $voucherCode)->first();
        if (!$voucher){
            return [
                'valid' => false,
                'message' => "Voucher not found"
            ];
        }
        if ($voucher->end_date < date('Y-m-d')){
            return [
                'valid' => false,
                'message' => "Voucher has expired"
            ];
        }
        if ($voucher->start_date > date('Y-m-d')){
            return [
                'valid' => false,
                'message' => "Voucher has not yet started"
            ];
        }
        if ($voucher->quantity <= 0){
            return [
                'valid' => false,
                'message' => "Voucher unavailable"
            ];
        }
        if ($voucher->min_price > $totalPrice){
            return [
                'valid' => false,
                'message' => "Voucher not applicable (min spend: ¥" . number_format($voucher->min_price) . ")"
            ];
        }
        return [
            'valid' => true,
            'message' => "Voucher applied",
            'voucher' => $voucher
        ];
    }

    private function setActiveVoucherCode($voucherCode)
    {
        session()->put('voucherCode', $voucherCode);
    }
}
