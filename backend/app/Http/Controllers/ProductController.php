<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
class ProductController extends Controller
{
    //
    public function create(Request $request)
    {
        $request->validate([
            'category_id'=>'required',
            'name'=>'required',
            'description'=>'nullable',
            'price'=>'required|numeric',
            'stock'=>'required|integer'

        ]);
        $user=$request->user();
        if(!$user){
            return response([
            'status'=>false,
            'message'=>'No user found',
           
        ],401);
        }
        $product=Product::create([
            'seller_id'=>$user->id,
            'category_id'=>$request->category_id,
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'stock'=>$request->stock,
        ]);

        return response([
            'status'=>true,
            'message'=>'Product created successfully',
            'product'=>$product
        ],201);
    }

    public function get(Request $request)
    {
        $products=Product::all();
        if(!$products){
            return response([
                'status'=>false,
                'message'=>'No Products available'
            ],404);
        }
         return response([
                'status'=>true,
                'message'=>'Products fetched successfully',
                'product'=>$products,
                
            ],200);
    }
    public function getProductById(Request $request,$id)
    {
        $products=Product::find($id);
        if(!$products){
            return response([
                'status'=>false,
                'message'=>'No Products available'
            ],404);
        }
         return response([
                'status'=>true,
                'message'=>'Products fetched successfully',
                'product'=>$products,
                
            ],200);
    }

    public function update(Request $request,$id)
    {
        $data=$request->validate([
            'category_id'=>'sometimes|string',
            'name'=>'sometimes|string',
            'description'=>'sometimes|string',
            'price'=>'sometimes|numeric',
            'stock'=>'sometimes|integer'
        ]);

        $product=Product::find($id);
        if(!$product){
            return response([
                'status'=>false,
                'message'=>'No Products available'
            ],404);
        }
        $product->update($data);
         return response([
                'status'=>true,
                'message'=>' Product updated successfully ',
                'product'=>$product->fresh()
            ],200);

    }

    public function delete(Request $request,$id)
    {
        $product=Product::find($id);
        if(!$product){
            return response([
                'status'=>false,
                'message'=>'No product found'

            ],404);
        }

        $product->delete();
        return response([
            'status'=>true,
            'message'=>'Product deleted successfully'
        ],200);

    }
}
