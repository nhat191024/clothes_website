<?php

namespace App\Service\admin;
use App\Models\Voucher;
use Illuminate\Http\Request;

class VoucherService
{
    public function getAll()
    {
        $voucher = Voucher::all();
        return $voucher;
    }

    public function getById($id)
    {
        return Voucher::where('id', $id)->first();
    }

    public function add(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'description' => 'required',
            'discount_percentage' => 'required|integer|min:0',
            'min_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $quantity = $request->quantity;
        if ($request->is_for_new_comers==1){
            $quantity = 1;
            $this->setAllVoucherAsNotForNewComers();
        }
        $id = Voucher::create([
            'code' => $request->code,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'min_price' => $request->min_price,
            'quantity' => $quantity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'is_for_new_comers' => $request->is_for_new_comers,
            'status' => 1,
        ])->id;

        return $id;
    }

    public function edit(Request $request)
    {
        $request->validate([
            'code' => 'required',
            'description' => 'required',
            'discount_percentage' => 'required|integer|min:0',
            'min_price' => 'required|integer|min:0',
            'quantity' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $voucher = Voucher::find($request->id);
        $voucher->code = $request->code;
        $voucher->description = $request->description;
        $voucher->discount_percentage = $request->discount_percentage;
        $voucher->min_price = $request->min_price;
        $voucher->quantity = $request->quantity;
        $voucher->start_date = $request->start_date;
        $voucher->end_date = $request->end_date;
        $voucher->status = $request->status;
        $voucher->is_for_new_comers = $request->is_for_new_comers;
        if ($request->is_for_new_comers==1){
            $voucher->quantity = 1;
            $this->setAllVoucherAsNotForNewComers();
        }
        $voucher->save();
    }

    public function delete($id)
    {
        $voucher = Voucher::find($id);
        $voucher->delete();
    }

    public function setAllVoucherAsNotForNewComers()
    {
        Voucher::where('is_for_new_comers', 1)->get()->each(function($voucher) {
            $voucher->end_date = \Carbon\Carbon::now();
            $voucher->is_for_new_comers = 0;
            $voucher->quantity = 1;
            $voucher->save();
        });
    }
}
