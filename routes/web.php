<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

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
    return redirect('/posts');
});

Route::get('/dashboard', function () {
    return redirect('/posts');
})->middleware(['auth'])->name('dashboard');


Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->middleware(['auth']) 
    ->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store');
Route::get('/posts/{post}', [PostController::class, 'show'])
    ->name('posts.show');
Route::post('/posts/{post}', [PostController::class, 'update'])
    ->name('posts.update');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])
    ->name('posts.delete');

Route::get('/users/create', [UserController::class, 'create'])->middleware(['auth']) 
    ->name('users.create');
Route::post('/users', [UserController::class, 'store'])->middleware(['auth']) 
    ->name('users.store');
Route::post("/users/logout", [UserController::class, 'logout'])
    ->name('users.logout');
Route::get('/users/{user}', [UserController::class, 'show'])
    ->name('users.show');
Route::post('/users/{user}/follow', [UserController::class, 'follow'])
    ->name('users.follow');
Route::delete('/users/{user}/unfollow', [UserController::class, 'unfollow'])
    ->name('users.unfollow');
Route::get('/{user}/notifications', [UserController::class, 'getNotifications'])
    ->name('users.notifications');
Route::delete('/notifications/{not}', [UserController::class, 'deleteNotifications'])
    ->name('notifications.delete');

Route::post("/comment/{post}", [CommentController::class, 'update'])
    ->name('comments.update');
Route::delete("/comment/{post}", [CommentController::class, 'destroy'])
    ->name('comments.delete');

Route::get('/users/logout', function () {
    return redirect('/posts');
});

Route::get('/postToInstagram/{text}', [PostController::class, 'postToInstagram']);

require __DIR__.'/auth.php';
