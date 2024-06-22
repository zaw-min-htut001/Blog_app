<?php

use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
/***
 * Auth routes
 */
Route::post('/register' ,[AuthController::class , 'register']);
Route::post('/login' ,[AuthController::class , 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout' , [AuthController::class , 'logout']);
    //profile api
    Route::get('/profile' ,[ProfileController::class , 'profile']);
    Route::get('/profile/posts' ,[ProfileController::class , 'posts']);

    //get All categories Api
    Route::get('/categories' ,[CategoryController::class , 'index']);

    //Post api
    Route::get('/post' ,[PostController::class , 'index']);
    Route::post('/post' ,[PostController::class , 'create']);
    Route::get('/post/{id}/detail' ,[PostController::class , 'show']);
    Route::delete('/post/{id}/delete' ,[PostController::class , 'destory']);
});
