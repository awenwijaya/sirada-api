<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Autentikasi\LupaPasswordController;

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

Route::get('forgetpassword/{email}', [LupaPasswordController::class, 'show_forget_password_page']);
Route::post('forgetpassword/reset/{email}', [LupaPasswordController::class, 'reset_password'])->name('reset.password');
