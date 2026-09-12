<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellerProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register',[UserController::class,'register']);

Route::get('/getuser',[UserController::class,'getUsers']);
Route::put('/updateuser/{id}',[UserController::class,'updateUser']);
Route::delete('/deleteuser/{id}',[UserController::class,'deleteUser']);

Route::post('/login',[UserController::class,'login']);

Route::middleware('auth:sanctum')->group( function (){
    Route::post('/logout',[UserController::class,'logout']);
    Route::post('/me',[UserController::class,'me']);
    Route::post('/changepassword',[UserController::class,'changePassword']);
    Route::post('/becomeseller',[SellerProfileController::class,'createSeller']);
    Route::post('/createproduct',[ProductController::class,'create']);
});

// category api
Route::post('/create',[CategoryController::class,'createCategory']);
Route::get('/get',[CategoryController::class,'getCategory']);
Route::get('/get/{id}',[CategoryController::class,'getCategoryById']);
Route::put('/update/{id}',[CategoryController::class,'updateCategoryById']);
Route::delete('/delete/{id}',[CategoryController::class,'deleteCategoryById']);

// seller profiles
Route::get('/getseller',[SellerProfileController::class,'get']);
Route::put('/updateseller/{id}',[SellerProfileController::class,'put']);
Route::delete('/deleteseller/{id}',[SellerProfileController::class,'delete']);

// Product api
Route::get('/getproduct',[ProductController::class,'get']);
Route::get('/getproduct/{id}',[ProductController::class,'getProductById']);
Route::put('/updateproduct/{id}',[ProductController::class,'update']);
Route::delete('/deleteproduct/{id}',[ProductController::class,'delete']);

// ProductImage api
Route::post('/createimage',[ProductImageController::class,'create']);
Route::get('/getimage',[ProductImageController::class,'read']);
Route::delete('/deleteimage/{id}',[ProductImageController::class,'delete']);