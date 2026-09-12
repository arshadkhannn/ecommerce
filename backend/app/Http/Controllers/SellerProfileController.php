<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerProfile;
class SellerProfileController extends Controller
{
    //

    public function createSeller(Request $request)
    {
        $request->validate([
            'business_name'=>'required',
            'phone'=>'required|digits:10',
            'address'=>'required'
        ]);

        $user=$request->user();
        if(!$user){
            return response([
                'status'=>false,
                'message'=>'No user found'
            ],401);
        }

        $existingseller=SellerProfile::where('user_id',$user->id)->first();
        if($existingseller){
             return response([
                'status'=>false,
                'message'=>'Seller application already submit'
            ],409);
        }

        $seller=SellerProfile::create([
            'user_id'=>$user->id,
            'business_name'=>$request->business_name,
            'phone'=>$request->phone,
            'address'=>$request->address,
            
        ]);

        return response([
            'status'=>true,
            'message'=>"Seller application submitted successfully",
            'seller'=>$seller
        ],201);
    }

    public function get(Request $request)
    {
        $sellers=SellerProfile::all();
        return response([
            'status'=>true,
            'message'=>"Seller fetched successfully",
            'sellers'=>$sellers
        ],200);
    }

    public function put(Request $request,$id)
    {
        $data=$request->validate([
            'business_name'=>'sometimes|string',
            'phone'=>'sometimes|digits:10',
            'address'=>'sometimes|string'
        ]);

        $seller=SellerProfile::find($id);
        if(!$seller){
            return response([
            'status'=>false,
            'message'=>"No seller found",
            
        ],401);
        }

        $seller->update($data);

        return response([
            'status'=>true,
            'message'=>"Seller updated successfully",
            'seller'=>$seller->fresh()
        ],200);
    }

    public function delete(Request $request,$id)
    {
        $seller=SellerProfile::find($id);
        if($seller){
            return response([
            'status'=>true,
            'message'=>"No seller found",
            
        ],401);
        }
        $seller->delete();
         return response([
            'status'=>true,
            'message'=>"Seller deletedsfully",
        
        ],200);

    }
}
