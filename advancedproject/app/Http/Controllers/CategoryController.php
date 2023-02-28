<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // add category
    public function addCategory(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',
            'type' => 'required|in:income,expense',
        ]);

        if ($validator->fails()) {
            $category = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $category;
        } else {
            $category = new Category;
            $category->name = $request->name;
            $category->type = $request->type;
            $category->save();
            $respond = [
                'status' => 200,
                'message' => 'category added successfully',
                'data' => $category,
            ];
            return $respond;
        }
    }
    // get all category
    public function getAllCategory(Request $request)
    {
        $categories = Category::all();
        $category = [
            'status' => 200,
            'message' => 'get all categories successfully',
            'data' => $categories,
        ];
        return $category;
    }

    // get category by id
    public function getCategory(Request $request, $id)
    {
        $category =  Category::find($id);
        if (!$category) {
            $respond = [
                'status' => 404,
                'message' => 'Category not found',
                'data' => null,
            ];

            return $respond;
        }
        if (($category)) {
            $respond = [
                'status' => 200,
                'message' => 'get category by id',
                'data' => $category,
            ];
            return $respond;
        }
    }

    // edit category by id
    public function editCategory(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'type' => 'required',
        ]);
        $category = Category::find($id);
        if (!$category) {
            $respond = [
                'status' => 404,
                'message' => 'Category not found',
                'data' => null,
            ];

            return $respond;
        }
        if ($validator->fails()) {
            $respond = [
                'status' => 401,
                'message' => $validator->errors()->first(),
                'data' => null,
            ];

            return $respond;
        } else {
            $category = Category::find($id);
            $category->name = $request->name;
            $category->type = $request->type;
            $category->save();

            $category = [
                'status' => 200,
                'message' => 'category edited successfully',
                'data' => $category,
            ];

            return $category;
        }
    }



    // delete category by id
    public function deleteCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (($category)) {
            $category->delete();
            $respond = [
                'status' => 200,
                'message' => 'category deleted successfully',
                'data' => $category,
            ];
            return $respond;
        } else {
            $error = [
                'satus' => 404,
                'message' => 'id not found',
                'data' => $category,
            ];
            return $error;
        }
    }
}
