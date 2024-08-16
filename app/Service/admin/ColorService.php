<?php

namespace App\Service\admin;

use App\Models\Color;

class ColorService
{
    public function getAllWithoutTrash()
    {
        $color = Color::all();
        return $color;
    }

    public function getAll()
    {
        $color = Color::withTrashed()->orderByRaw('deleted_at IS NOT NULL')
            ->orderBy('created_at', 'desc')
            ->get();
        return $color;
    }

    public function checkHasName($name, $id = null)
    {
        if ($id == null) {
            return Color::withTrashed()->where('name', $name)->exists();
        } else { 
            return Color::withTrashed()->where('name', $name)->where('id', '!=', $id)->exists();
        }
    }

    public function getById($id) {
        return Color::withTrashed()->where('id', $id)->first();
    }

    public function add($name, $colorHex)
    {
        Color::create([
            'name' => $name,
            'color_hex' => $colorHex,
        ]);
    }

    public function edit($id, $categoryName, $colorHex)
    {
        $category = Color::where('id', $id)->first();
        $category->name = $categoryName;
        $category->color_hex = $colorHex;
        $category->save();
    }

    public function checkHasChildren($idColor) {
        return Color::find($idColor)->productDetail()->get()->count() > 0;
    }

    public function delete($idColor)
    {
        Color::find($idColor)->delete();
    }

    public function restore($idColor)
    {
        $size = Color::withTrashed()->find($idColor);
        if ($size) {
            $size->restore(); // Khôi phục sản phẩm
        }
    }
}
