<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductImage;
class ProductImageController extends Controller
{
    //

    public function create(Request $request)
    {
       $request->validate([
    'product_id' => 'required|exists:products,id',
    'image' => 'required|array|min:1',
    'image.*'=>'image|mimes:jpg,jpeg,png,webp|max:2048'
]);

    $images=[];

    foreach($request->file('image') as $image){
        $path=$image->store('products','public');

        $productimage=ProductImage::create([
            'product_id'=>$request->product_id,
            'image'=>$path
        ]);

        $images[]=$productimage;

        
    }
     return response([
            'status'=>true,
            'message'=>'Image posted successfully',
            'images'=>$images
        ],201);

    }

    public function read(Request $request)
    {
        $images=ProductImage::all();
        if(!$images){
            return response([
                'status'=>false,
                'message'=>'No images found'
            ],403);
        }

        return response([
            'status'=>true,
                'message'=>' images fetched successfully ',
                'images'=>$images
        ],200);
        
    }

    public function delete(Request $request,$id){

    $images=ProductImage::find($id);
    if(!$images){
            return response([
                'status'=>false,
                'message'=>'No images found'
            ],403);
        }
    $images->delete();
        return response([
            'status'=>true,
                'message'=>' images deleted successfully',
        ],200);
        
    
    }
}
