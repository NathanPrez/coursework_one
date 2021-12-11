<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;

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
    //return view('welcome');
    return redirect('/posts');
});

Route::get('/dashboard', function () {
    return redirect('/posts');
})->middleware(['auth'])->name('dashboard');

Route::get('/posts', [PostController::class, 'index'])
    ->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])
    ->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])
    ->name('posts.store');

Route::get('/posts/{id}', [PostController::class, 'show'])
    ->name('posts.show');

Route::get('/users', [UserController::class, 'index'])
    ->name('users.index');
Route::get('/users/create', [UserController::class, 'create'])
    ->name('users.create');

Route::post('/users', [UserController::class, 'store'])
    ->name('users.store');

Route::post("/users/logout", [UserController::class, 'logout'])
    ->name('users.logout');

Route::get('/users/logout', function () {
    return redirect('/posts');
});

require __DIR__.'/auth.php';
