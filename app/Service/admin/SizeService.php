<?php

namespace App\Service\admin;

use App\Models\Size;

class SizeService
{
    public function getAll()
    {
        $size = Size::withTrashed()->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('created_at', 'desc')
            ->get();
        return $size;
    }
    public function getAllWithoutTrash()
    {
        $size = Size::orderBy('created_at', 'desc')
            ->get();
        return $size;
    }

    public function checkHasName($name, $id = null)
    {
        if ($id == null) {
            return Size::withTrashed()->where('name', $name)->exists();
        } else { 
            return Size::withTrashed()->where('name', $name)->where('id', '!=', $id)->exists();
        }
    }

    public function getById($id)
    {
        return Size::withTrashed()->where('id', $id)->first();
    }

    public function add($sizeName)
    {
        Size::create([
            'name' => $sizeName,
        ]);
    }

    public function edit($id, $sizeName)
    {
        $size = Size::withTrashed()->where('id', $id)->first();
        $size->name = $sizeName;
        $size->save();
    }

    public function checkHasChildren($idsize)
    {
        return Size::find($idsize)->productDetail()->get()->count() > 0;
    }

    public function delete($idsize)
    {
        Size::find($idsize)->delete();
    }

    public function restore($idsize)
    {
        $size = Size::withTrashed()->find($idsize);
        if ($size) {
            $size->restore(); // Khôi phục sản phẩm
        }
    }
}
