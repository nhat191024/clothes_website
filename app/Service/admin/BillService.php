<?php

namespace App\Service\admin;

use App\Models\Bill;
use App\Models\BillDetail;

class BillService
{
    public function getAll()
    {
        $bill = Bill::orderBy('status')->get();
        return $bill;
    }

    public function getById($id) {
        return Bill::where('id', $id)->first();
    }

    public function getAllByIdBill($billId)
    {
        $billDetailArray = BillDetail::where('bill_id', $billId)->get();
        return $billDetailArray;
    }

    public function updateStatus($id, $status)
    {
        $method = Bill::where('id', $id)->first();
        $method->status = $status;
        $method->save();
    }
}
