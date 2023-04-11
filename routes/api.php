<?php

use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', [UserController::class, 'login'])->name('user.login'); //check
Route::post('/register', [UserController::class, 'store'])->name('user.store'); //check
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show'); //check
Route::get('/user', [UserController::class, 'index'])->name('user.index'); //check
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout'); // cek sama rapli
Route::put('user/edit/{id}', [UserController::class, 'update'])->name('user.update'); //check
Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy'); //check

Route::get('/comment', [CommentController::class, 'index'])->name('comment.index'); //check
Route::get('/comment/{id}', [CommentController::class, 'show'])->name('comment.show'); //check
Route::post('/comment', [CommentController::class, 'store'])->name('comment.store'); //check
Route::put('/comment/{id}', [CommentController::class, 'update'])->name('comment.update'); //check
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy'); //check

Route::get('/reply', [ReplyController::class, 'index'])->name('reply.index'); //check
Route::get('/reply/{id}', [ReplyController::class, 'show'])->name('reply.show'); //check
Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store'); //check
Route::put('/reply/{id}', [ReplyController::class, 'update'])->name('reply.update'); //check
Route::delete('/reply/{id}', [ReplyController::class, 'destroy'])->name('reply.destroy'); //check