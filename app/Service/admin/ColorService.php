<?php

namespace App\Service\admin;

use App\Models\Color;

class ColorService
{
    public function getAll()
    {
        $category = Color::all();
        return $category;
    }

    public function getById($id) {
        return Color::where('id', $id)->first();
    }

    public function add($categoryName)
    {
        Color::create([
            'name' => $categoryName,
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
