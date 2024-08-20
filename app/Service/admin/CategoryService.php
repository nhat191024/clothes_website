<?php

namespace App\Service\admin;

use App\Models\Category;

class CategoryService
{
    public function getAll()
    {
        $category = Category::all();
        return $category;
    }

    public function getById($id) {
        return Category::where('id', $id)->first();
    }

    public function add($categoryName)
    {
        Category::create([
            'name' => $categoryName,
        ]);
    }

    public function edit($id, $categoryName)
    {
        $category = Category::where('id', $id)->first();
        $category->name = $categoryName;
        $category->save();
    }

    public function checkHasChildren($idCategory) {
        return Category::find($idCategory)->products()->get()->count() > 0;
    }

    public function delete($idCategory) {
        Category::destroy($idCategory);
    }
}
