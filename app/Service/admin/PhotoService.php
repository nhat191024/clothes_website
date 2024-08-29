<?php

namespace App\Service\admin;

use App\Models\Image;
use Illuminate\Support\Facades\File;

class PhotoService
{
    public function getAll($id)
    {
        return Image::where('product_id', $id)->get();
    }

    public function getById($id)
    {
        return Image::where('id', $id)->first();
    }

    public function edit($id, $name, $type)
    {
        $about = Image::where('id', $id)->first();
        $about->name = $name;
        $about->type = $type;
        $about->save();
    }

    public function addPhoto($id, $images)
    {
        foreach ($images as $image) {
            $imageName =  uniqid() . '_' . $image->getClientOriginalName();
            // Lưu trữ tệp ảnh vào thư mục
            $image->move(public_path('img/product'), $imageName);
            Image::insert([
                'product_id' => $id,
                'img' => $imageName
            ]);
        }
    }

    public function deleteAllPhoto($id)
    {
        $allPhotos = Image::where('product_id', $id)->get();
        foreach ($allPhotos as $item) {
            $imagePath = public_path('img/product/' . $item->img);
            if (File::exists($imagePath)) {
                // Xóa file
                File::delete($imagePath);
            }
            $item->delete();
        }
    }

    public function deleteOnePhoto($id)
    {
        $photoDetail = Image::find($id);
        if ($photoDetail) {
            $imagePath = public_path('img/product/' . $photoDetail->img) ?? '';
            if (File::exists($imagePath)) {
                // Xóa file
                File::delete($imagePath);
            }
            $photoDetail->delete();
        }
    }
}
