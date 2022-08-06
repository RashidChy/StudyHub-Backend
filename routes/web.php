<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\GithubController;
use App\Http\Controllers\ProblemController;
use App\Http\Controllers\FacebookController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//routes

//all problems
Route::get('/', [ProblemController::class, 'index']);


//Show create form
Route::get('/problems/create', [ProblemController::class, 'create'])
      ->middleware('auth');

//manage
Route::get('/problems/manage', [ProblemController::class, 'manage'])
      ->middleware('auth');

//store problem datas
Route::post('/problems', [ProblemController::class, 'store'])
      ->middleware('auth');

//store problem datas
Route::get('problems/storage/files/{name}', [ProblemController::class, 'showFile'])
      ->middleware('auth');

//edit
Route::get('/problems/{id}/edit', [ProblemController::class, 'edit'])
      ->middleware('auth');

//update
Route::put('/problems/{id}', [ProblemController::class, 'update'])
      ->middleware('auth');

//delete
Route::delete('/problems/{id}', [ProblemController::class, 'delete'])
      ->middleware('auth');


//single problems
Route::get('/problems/{id}', [ProblemController::class, 'show'])
      ->middleware('auth');



//register
Route::get('/register', [UserController::class, 'create'])
      ->middleware('guest');

//create user
Route::post('/user', [UserController::class, 'store']);

//show user
Route::get('/user/profile', [UserController::class, 'show'])
      ->middleware('auth');

//update user
Route::put('/user/profile', [UserController::class, 'update'])
      ->middleware('auth');

//logout
Route::post('/logout', [UserController::class, 'logout'])
      ->middleware('auth');

//login form
Route::get('/login', [UserController::class, 'login'])->name('login')
      ->middleware('guest');

//login
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

//******************* */

// *******admin operations******


Route::get('/adminOperations/user', [AdminController::class, 'users'])->middleware('auth');;

Route::get('/adminOperations/posts', [AdminController::class, 'posts'])->middleware('auth');;

Route::get('/adminOperations/addAdmin', [AdminController::class, 'adminRegistration'])->middleware('auth');;

Route::post('/adminOperations/user', [AdminController::class, 'addAdmin'])->middleware('auth');;

Route::delete('adminOperations/user/{id}', [AdminController::class, 'deleteUser'])->middleware('auth');;

Route::delete('adminOperations/posts/{id}', [AdminController::class, 'deletePost'])->middleware('auth');;


//*************************** 

//*********************** */

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group(function () {
      Route::get('auth', [FaceBookController::class, 'loginUsingFacebook'])->name('login');
      Route::get('callback', [FaceBookController::class, 'callbackFromFacebook'])->name('callback');
});
// Github Login URL
Route::prefix('github')->name('github.')->group(function () {
      Route::get('auth', [GithubController::class, 'loginUsingGithub'])->name('login');
      Route::get('callback', [GithubController::class, 'callbackFromGithub'])->name('callback');
});


////////////////////////////////////////////////////


Route::post('/problems/show/{id}', [CommentController::class, 'storeComment'])->middleware('auth');
