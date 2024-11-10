<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\LoginController;
use App\Http\Controllers\admin\index\IndexController;
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
Route::match(['get', 'post'], '/login',[LoginController::class, 'index']);
// route for logout
Route::match(['get', 'post'], '/logout',[LoginController::class, 'logout']);
// route for getting captcha
Route::get('captcha',[LoginController::class, 'captcha'])->name('captcha');
// route for admin index page
Route::get('admin/index', [IndexController::class, 'index']);
