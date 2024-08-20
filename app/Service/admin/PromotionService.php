<?php

namespace App\Service\admin;

use App\Models\Promotion;

class PromotionService
{
    public function get()
    {
        return Promotion::first();
    }

    public function edit($request)
    {
        $promotion = PromotionService::get();
        $promotion->product_id = $request->product_id;
        $promotion->discount_percentage = $request->discount_percentage;
        $promotion->start_time = $request->start_time;
        $promotion->end_time = $request->end_time;
        return $promotion->save();
    }
}
