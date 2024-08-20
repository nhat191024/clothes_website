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

        $id = Voucher::create([
            'code' => $request->code,
            'description' => $request->description,
            'discount_percentage' => $request->discount_percentage,
            'min_price' => $request->min_price,
            'quantity' => $request->quantity,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
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
        $voucher->save();
    }

    public function delete($id)
    {
        $voucher = Voucher::find($id);
        $voucher->delete();
    }
}
