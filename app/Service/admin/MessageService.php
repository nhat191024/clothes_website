<?php

namespace App\Service\admin;
use App\Models\CustomerRequest;

class MessageService
{
    public function getAll()
    {
        $ContactUs = CustomerRequest::orderBy('created_at', 'desc')->get();
        return $ContactUs;
    }

    public function getAllDeleted()
    {
        $ContactUs = CustomerRequest::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return $ContactUs;
    }

    public function getById($id)
    {
        return CustomerRequest::where('id', $id)->first();
    }

    public function recoverById($id)
    {
        $ContactUs = CustomerRequest::withTrashed()->find($id);
        $ContactUs->restore();
        return $ContactUs;
    }

    public function deleteById($id)
    {
        try {
            $ContactUs = CustomerRequest::find($id);
            $ContactUs->delete();
        } catch (\Throwable $th) {
        }
    }

    public function deleteAll()
    {
        $ContactUss = CustomerRequest::all();
        foreach ($ContactUss as $ContactUs) {
            $ContactUs->delete();
        }
    }
}
