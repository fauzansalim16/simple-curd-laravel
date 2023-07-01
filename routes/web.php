<?php

use App\Http\Controllers\mahasiswaController;
use App\Http\Controllers\SessionController;
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

Route::resource('mahasiswa', mahasiswaController::class)->middleware('isLogin');

Route::get('sesi', [SessionController::class, 'index'])->middleware('isTamu');
Route::post('sesi/login', [SessionController::class, 'login'])->middleware('isTamu');
Route::get('sesi/logout', [SessionController::class, 'logout']);
Route::get('sesi/register', [SessionController::class, 'register'])->middleware('isTamu');
Route::post('sesi/register', [SessionController::class, 'create'])->middleware('isTamu');