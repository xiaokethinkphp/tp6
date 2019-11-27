<?php


namespace app\api\controller;
use app\api\model\Category as CategoryModel;
use app\api\validate\IDMustBePostiveInt;

class Category
{
    public function getAllCategories()
    {
        $categories = CategoryModel::with(['img'])->select();
        if ($categories->isEmpty()) {
            throw new CategoryException();
        }
        return $categories;
    }

    public function getAllInCategory($id)
    {
        (new IDMustBePostiveInt())->goCheck();
    }
}