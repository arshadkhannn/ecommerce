<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            
        ]);

        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>bcrypt($request->password),
           
           
        ]);

        
        $token=$user->createToken('user-token')->plainTextToken;
        return response([
            'status' => true,
            'message' => 'User created successfully',
            'user' => $user,
            'token' => $token
        ]);
    }

    public function getUsers(Request $request)
    {
        $user=User::all();
        return response([
            'status'=>true,
            'message'=>'User fetched successfully',
            'user'=>$user

        ]);
    }

    public function updateUser(Request $request,$id)
    {

        $data=$request->validate([
            'name'=>'sometimes|string',
            'email'=>'sometimes|email',
            'role'=>'sometimes|string',
        ]);
        $user=User::find($id);

        if(!$user){
            return response([
                'status'=>false,
                'message'=>'No user found'

            ]);
        }

        $user->update($data);
         return response([
            'status'=>true,
            'message'=>'User updated successfully',
            'user'=>$user->fresh()

        ]);

        
    }

    public function deleteUser(Request $request,$id)
    {
        $user=User::find($id);
        if(!$user){
            return response([
                'status'=>false,
                'message'=>'No user found'

            ]);
        }

        $user->delete();
        return response([
            'status'=>true,
            'message'=>'User deleted successfully'
        ]);

    }

    public function login(Request $request)
    {
        $credentials=$request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);


        if(Auth::attempt($credentials)){
            $user=Auth::user();

            $token=$user->createToken('user-token')->plainTextToken;
            return response([
                'status'=>true,
                'message'=>'logged in successfully',
                'user'=>$user,
                'token'=>$token
            ]);
        }
         return response([
                'status'=>false,
                'message'=>'Invalid email or password',
                
            ],403);
        
    }

   
    public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete();

    return response([
        'status' => true,
        'message' => 'User logged out successfully'
    ]);
}

 public function me(Request $request)
 {
    $user=$request->user();
    if(!$user){
        return response([
            'status'=>false,
            'message'=>'No user logged in'
        ]);
    }

    return response([
        'status'=>true,
        'user'=>$user
    ]);
 }

 public function changePassword(Request $request)
 {
    $user=$request->user();
    $request->validate([
        'old_password'=>'required',
        'new_password'=>'required|min:6|different:old_password'
    ]);

    if(!Hash::check($request->old_password,$user->password)){
        return response([
            'status'=>false,
            'message'=>"Old password is incorrect"
        ]);
    }
    $user->update([
        'password'=>Hash::make($request->new_password)
    ]);
    return response([
        'status'=>true,
        'message'=>'Password changed successfully'
    ]);
 }
}