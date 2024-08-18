<?php

namespace App\Service\admin;

use App\Models\Banners;
use App\Models\ContactInfo;

class AboutUsService
{
    public function getAll()
    {
        $about = ContactInfo::first();
        return $about;
    }

    public function getById($id)
    {
        return ContactInfo::where('id', $id)->first();
    }

    public function edit($id, $name, $type)
    {
        $about = ContactInfo::where('id', $id)->first();
        $about->name = $name;
        $about->type = $type;
        $about->save();
    }
}
