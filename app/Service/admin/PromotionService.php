<?php

namespace App\Service\admin;

use App\Models\Promotion;

class PromotionService
{
    public function get()
    {
        return Promotion::all();
    }
    public function getById($id)
    {
        return Promotion::find($id);
    }

    public function edit($request)
    {
        $request->validate([
            'id' => 'required|exists:promotions,id',
            'product_id' => 'required|exists:products,id',
            'description' => 'nullable|string',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
        $promotion = PromotionService::getById($request->id)->first();
        $promotion->product_id = $request->product_id;
        $promotion->description = $request->description;
        $promotion->discount_percentage = $request->discount_percentage;
        $promotion->start_time = $request->start_time;
        $promotion->end_time = $request->end_time;
        // $promotion->id = $request->id;
        return $promotion->save();
    }
}
