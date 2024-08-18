<?php

namespace App\Service\admin;
use App\Models\ContactUs;

class MessageService
{
    public function getAll()
    {
        $ContactUs = ContactUs::orderBy('created_at', 'desc')->get();
        return $ContactUs;
    }

    public function getAllDeleted()
    {
        $ContactUs = ContactUs::onlyTrashed()->orderBy('deleted_at', 'desc')->get();
        return $ContactUs;
    }

    public function getById($id)
    {
        return ContactUs::where('id', $id)->first();
    }

    public function recoverById($id)
    {
        $ContactUs = ContactUs::withTrashed()->find($id);
        $ContactUs->restore();
        return $ContactUs;
    }

    public function deleteById($id)
    {
        try {
            $ContactUs = ContactUs::find($id);
            $ContactUs->delete();
        } catch (\Throwable $th) {
        }
    }

    public function deleteAll()
    {
        $ContactUss = ContactUs::all();
        foreach ($ContactUss as $ContactUs) {
            $ContactUs->delete();
        }
    }
}
