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

    public function applyVoucher($voucherCode, $subTotal)
    {
        $checkResult = $this->checkVoucher($voucherCode, $subTotal);
        if ($checkResult) {
            ($checkResult['valid']) ? $this->setActiveVoucherCode($voucherCode) : $this->clearVoucher();
            return [
                'subtotal' => $subTotal,
                'discount' => $this->getDiscountAmount($subTotal),
                'checkResult' => $checkResult
            ];
        }
    }

    public function getDiscountAmount($cartSubtotal)
    {
        $voucher = $this->getActivatedVoucher($cartSubtotal);
        if ($voucher == null || !isset($voucher)) {
            return 0;
        }
        $discount = $cartSubtotal * $voucher->discount_percentage / 100;
        if ($voucher->max_price == null)
            return $discount;
        return ($discount>$voucher->max_price) ? $voucher->max_price : $discount;
    }

    public function getActivatedVoucher($cartSubtotal)
    {
        $voucherCode = session()->get('voucherCode');
        $result = $this->checkVoucher($voucherCode, $cartSubtotal);
        if ($result['valid']) {
            return $result['voucher'];
        }
        $this->setActiveVoucherCode(null);
        return null;
    }

    private function checkVoucher($voucherCode, $cartSubtotal)
    {
        $voucher = Voucher::where('code', $voucherCode)->first();

        if (!$voucher) {
            return ['valid' => false, 'message' => "Voucher not found"];
        }

        if ($voucher->status == 0) {
            return ['valid' => false, 'message' => "Voucher unavailable"];
        }

        if ($voucher->end_date < date('Y-m-d')) {
            return ['valid' => false, 'message' => "Voucher has expired"];
        }

        if ($voucher->start_date > date('Y-m-d')) {
            return ['valid' => false, 'message' => "Voucher has not yet started"];
        }

        if ($voucher->quantity <= 0) {
            return ['valid' => false, 'message' => "Voucher has run out"];
        }

        if ($voucher->min_price > $cartSubtotal) {
            return ['valid' => false, 'message' => "Voucher not applicable (min spend: ¥" . $voucher->min_price . ")"];
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
