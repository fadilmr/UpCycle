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
Route::get('/logout', [UserController::class, 'logout'])->name('user.logout'); 
Route::put('user/edit/{id}', [UserController::class, 'update'])->name('user.update'); //check
Route::delete('user/delete/{id}', [UserController::class, 'destroy'])->name('user.destroy'); //check
