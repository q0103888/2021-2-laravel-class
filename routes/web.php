<?php

use App\Http\Controllers\PostsController;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function () {
    return view('welcome');
});

// view가 의미하는것을 해당 사이트의 정보를 전달(랜더링)해라 라는 뜻

Route::get('/layout', function () {
    return view('layouts.app');
});

Route::get('/hello', function () {
    return view('hello');
});

// Route::get('/posts', [PostsController::class, 'index']);
// Route::get('/create', [PostsController::class, 'create']);
// Route::get('/store', [PostsController::class, 'store']);

Route::resource('/posts', PostsController::class);