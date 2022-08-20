<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostApiController;


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

// Login and Registration

Route::post('/auth/register', [AuthController::class, 'createUser']);
Route::post('/auth/login', [AuthController::class, 'loginUser']);

// 
Route::get('/adminOperations/user', [AdminController::class, 'usersApi']);

// All posts

Route::get('/posts/all', [PostApiController::class, 'viewListing']);

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/posts/create', [PostApiController::class, 'create']); // create

    Route::get('/user/posts', [PostApiController::class, 'viewPost']); //  read

    Route::put('/updatePost/{id}', [PostApiController::class, 'update']); // update

    Route::delete('/posts/{id}', [PostApiController::class, 'destroy']); // delete
});
