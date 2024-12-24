<?php

use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('components.read');
// });


Route::get('/product',[ProductController::class,'index']);


Route::get('/product-list',[ProductController::class,'productList']);
Route::post('/create',[ProductController::class,'create']);
Route::get('/product/delete/{id}',[ProductController::class,'destroy']);
Route::get('/find-product/{id}',[ProductController::class,'show']);
Route::post('/update/{id}',[ProductController::class,'edit']);
Route::get('/find-update/{id}',[ProductController::class,'find']);





