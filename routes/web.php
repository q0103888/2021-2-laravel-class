<?php

use App\Http\Controllers\CommentsController;
use App\Http\Controllers\LikesController;
use App\Http\Controllers\PostsController;
use App\Models\Comment;
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

Route::resource('/posts', PostsController::class)->middleware(['auth']);

Route::delete('/posts/images/{id}',
                [PostsController::class, "deleteImage"])
                ->middleware(['auth']);


// Route::get('/posts', [PostsController::class, "index"])
//     ->name('posts.index'11);
// Route::Post('/posts', [PostsController::class, "store"])
//     ->name('posts.index');

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');



Route::get('/getcomments/{postId}', [CommentsController::class,"index"])->middleware('auth')->name('comment.index');

Route::post('/like/{post}', [LikesController::class, "store"])
                                ->middleware(['auth'])->name('like.store');

Route::post('/comments/{postId}', 
            [CommentsController::class, 'store']);
            

Route::patch('/comments/{commentId}',
            [CommentsController::class, 'update']);

Route::delete('/comments/{comment_id}',
                    [CommentsController::class, 'destroy']);

require __DIR__.'/auth.php';
