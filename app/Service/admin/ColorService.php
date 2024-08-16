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
        return Color::where('id', $id)->first();
    }

    public function add($name, $colorHex)
    {
        Color::create([
            'name' => $name,
            'color_hex' => $colorHex,
        ]);
    }

    public function edit($id, $categoryName)
    {
        $category = Color::where('id', $id)->first();
        $category->name = $categoryName;
        $category->save();
    }

    public function checkHasChildren($idCategory) {
        return Color::find($idCategory)->product()->get()->count() > 0;
    }

    public function delete($idCategory) {
        Color::destroy($idCategory);
    }
}
