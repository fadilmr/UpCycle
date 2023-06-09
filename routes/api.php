<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReplyController;
use App\Http\Controllers\TransactionController;
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

Route::get('/comment', [CommentController::class, 'index'])->name('comment.index');
Route::get('/comment/{id}', [CommentController::class, 'show'])->name('comment.show');
Route::get('/comment/product/{id}', [CommentController::class, 'showProduct'])->name('comment.showProduct');
Route::post('/comment', [CommentController::class, 'store'])->name('comment.store');
Route::put('/comment/{id}', [CommentController::class, 'update'])->name('comment.update');
Route::delete('/comment/{id}', [CommentController::class, 'destroy'])->name('comment.destroy');

Route::get('/reply', [ReplyController::class, 'index'])->name('reply.index');
Route::get('/reply/{id}', [ReplyController::class, 'show'])->name('reply.show');
Route::post('/reply', [ReplyController::class, 'store'])->name('reply.store');
Route::put('/reply/{id}', [ReplyController::class, 'update'])->name('reply.update');
Route::delete('/reply/{id}', [ReplyController::class, 'destroy'])->name('reply.destroy');

//product
Route::get('/product', [ProductController::class, 'index'])->name('product.index'); //check
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show'); //check
Route::get('/product/user/{id}', [ProductController::class, 'showUser'])->name('product.showUser'); //check
Route::post('/product', [ProductController::class, 'store'])->name('product.store'); //check
Route::post('/product/edit/{id}', [ProductController::class, 'update'])->name('product.update')->middleware('cors'); // check
Route::delete('/product/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy'); //check

//transaksi
Route::get('/transaction', [TransactionController::class, 'index'])->name('transaksi.index'); //check
Route::get('/transaction/{id}', [TransactionController::class, 'show'])->name('transaksi.show'); //check
Route::get('/transaction/user/{id}', [TransactionController::class, 'showUser'])->name('transaksi.showUser'); //check
Route::post('/transaction', [TransactionController::class, 'store'])->name('transaksi.store'); //check
Route::put('/transaction/edit/{id}', [TransactionController::class, 'update'])->name('transaksi.update'); //check
Route::put('/transaction/konfirmasi/{id}', [TransactionController::class, 'konfirmasi'])->name('transaksi.konfirmasi'); //check
Route::delete('/transaction/delete/{id}', [TransactionController::class, 'destroy'])->name('transaksi.destroy'); //check
