<?php

namespace App\Service\admin;

use App\Models\Bill;
use App\Models\BillDetail;
use App\Service\PointService;

class BillService
{
    private $pointService;

    public function __construct()
    {
        $this->pointService = app(PointService::class);
    }

    public function getAll()
    {
        $bill = Bill::orderBy('status')->get();
        return $bill;
    }

    public function getById($id)
    {
        return Bill::where('id', $id)->first();
    }

    public function getAllByIdBill($billId)
    {
        $billDetailArray = BillDetail::where('bill_id', $billId)->get();
        return $billDetailArray;
    }

    public function updateStatus($id, $status)
    {
        $bill = Bill::where('id', $id)->first();
        $bill->status = $status;

        if ($bill->user_id && $status == 1) {
            $bill->points_for_user = $this->pointService->addPoint($bill->user_id, $bill->total);
        }

        $bill->save();
    }
}
