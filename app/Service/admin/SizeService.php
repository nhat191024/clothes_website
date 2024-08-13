<?php

namespace App\Service\admin;

use App\Models\Size;

class SizeService
{
    public function getAll()
    {
        $category = Size::all();
        return $category;
    }

    public function getById($id) {
        return Size::where('id', $id)->first();
    }

    public function add($categoryName)
    {
        Size::create([
            'name' => $categoryName,
        ]);
    }

    public function edit($id, $categoryName)
    {
        $category = Size::where('id', $id)->first();
        $category->name = $categoryName;
        $category->save();
    }

    public function checkHasChildren($idCategory) {
        return Size::find($idCategory)->product()->get()->count() > 0;
    }

    public function delete($idCategory) {
        Size::destroy($idCategory);
    }
}
