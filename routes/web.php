<?php

use App\Http\Controllers\admin\DevController;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\admin\LoginController;
use App\Http\Middleware\UserAuth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// route for login
Route::match(['get', 'post'], '/login', [LoginController::class, 'index']);
// route for logout
Route::match(['get', 'post'], '/logout', [LoginController::class, 'logout']);
// route for getting captcha
Route::get('captcha', [LoginController::class, 'captcha'])->name('captcha');

// route for all admin pages
Route::middleware([UserAuth::class])->prefix('admin')->group(function () {
    Route::get('/index/index', [IndexController::class, 'index']);
    Route::match(['get', 'post'], '/dev/index', [DevController::class, 'index']);
});
