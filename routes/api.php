<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::post('/add', [ProductController::class, 'addProduct']);
Route::get('/list', [ProductController::class, 'allProduct']);
Route::delete('/delete/{id}', [ProductController::class, 'deleteProduct']);
Route::get('/edit/{id}', [ProductController::class, 'editProduct']);
Route::post('/update/{id}', [ProductController::class, 'updateProduct']);
Route::get('/search', [ProductController::class, 'searchProduct']);

