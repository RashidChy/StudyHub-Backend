<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CommentApiController;
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


// user//


Route::get('/adminOperations/user', [AdminController::class, 'usersApi']); // get all users Admin

Route::put('/users/{id}', [AuthController::class, 'updateProfile']); // update user (Users + Admin Privilege) 

Route::delete('/users/{id}', [AuthController::class, 'destroyUser']); // delete user (Users + Admin Privilege) 



////

// posts ////

///

Route::get('/posts/all', [PostApiController::class, 'viewListing']);  // Public + Admin Privilege

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::post('/posts/create', [PostApiController::class, 'create']); // create

    Route::get('/user/posts', [PostApiController::class, 'viewPost']); //  read

    Route::put('/updatePost/{id}', [PostApiController::class, 'update']); // update



    // **************************************************
    // sakin, specefic problem id diye specefic post get korar jnne ekta api banaite hbe
    // example:   Route::get('/post/{id}', [PostApiController::class, 'show']);

    // dilam
    // **************************************************


    Route::get('/user/posts/{id}', [PostApiController::class, 'viewSinglePost']); //  read single post

    Route::delete('user/posts/{id}', [PostApiController::class, 'destroy']); // delete (Users + Admin Privilege) 
});


// Comments //

Route::group(['middleware' => ['auth:sanctum']], function () {

    Route::get('/comment/{id}', [CommentApiController::class, 'fetch']);

    Route::post('/addComment/{id}', [CommentApiController::class, 'addComment']);
});




// **************ADMIN OPERATIONS**************************

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/Admin/create', [AdminApiController::class, 'createAdmin']);
    Route::get('/Admin/AdminDetails', [AdminApiController::class, 'viewAdminProfile']);

    Route::get('/Admin/allAdmin', [AdminApiController::class, 'viewAllAdmins']);
    Route::get('/Admin/Users', [AdminApiController::class, 'viewUsers']);
    Route::get('/Admin/Comments', [AdminApiController::class, 'viewComments']);
    Route::get('/Admin/Posts', [AdminApiController::class, 'viewPosts']);

    Route::put('/Admin/UpdateUser/{id}', [AdminApiController::class, 'updateProfile']);
    Route::put('/Admin/UpdatePost/{id}', [AdminApiController::class, 'updatePost']);

    Route::delete('/Admin/DeleteUser/{id}', [AdminApiController::class, 'destroyUser']);
    Route::delete('/Admin/DeletePost/{id}', [AdminApiController::class, 'destroyPost']);
    Route::delete('/Admin/DeleteComment/{id}', [AdminApiController::class, 'destroyComment']);
});

//***************************************************************