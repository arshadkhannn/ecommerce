<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
class CategoryController extends Controller
{
    //
    public function getCategory(Request $request)
    {
        $categories=Category::all();
        return response([
            'status'=>true,
            'message'=>'Category fetched successfully',
            'categories'=>$categories
        ]);
    }

    public function createCategory(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:categories,name'
        ]);

        $category=Category::create([
            'name'=>$request->name
        ]);
         return response([
            'status'=>true,
            'message'=>'Category created successfully',
            'category'=>$category
        ]);

    }
    public function getCategoryById(Request $request,$id)
    {
        $categories=Category::find($id);
        if(!$categories){
            return response([
            'status'=>false,
            'message'=>'No category found',
            
        ]);

        }

        return response([
            'status'=>true,
            'message'=>'Category found successfully',
            'categories'=>$categories
        ]);
    }
    public function updateCategoryById(Request $request,$id)
    {

        $data=$request->validate([
            'name'=>'sometimes|string'
        ]);

        $categories=Category::find($id);
        if(!$categories){
            return response([
            'status'=>false,
            'message'=>'No category found',
            
        ]);
        }
        $categories->update($data);

        return response([
            'status'=>true,
            'message'=>'Category updated successfully',
            'categories'=>$categories
        ]);
    }
    public function deleteCategoryById(Request $request,$id)
    {

        
        $categories=Category::find($id);
        if(!$categories){
            return response([
            'status'=>false,
            'message'=>'No category found',
            
        ]);
        }
        $categories->delete();

        return response([
            'status'=>true,
            'message'=>'Category deleted successfully',
            
        ]);
    }
}
