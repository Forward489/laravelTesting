<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LoginController;

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

// route untuk login, menampilkan page login
Route::get('/', [LoginController::class, 'login']);
// route untuk register, menampilkan page register
Route::get('/register', [LoginController::class, 'register']);
// route untuk login, methodnya post, melakukan validasi
Route::post('/login', [LoginController::class, 'authenticate']);
// route untuk register, methodnya post, melakukan storing data
Route::post('/register', [LoginController::class, 'store']);

// route untuk logout
Route::post('/logout', [LoginController::class, 'logout']);

// route untuk home, menampilkan page home, dan harus login terlebih dahulu, middleware auth untuk mengecek apakah sudah login atau belum
Route::get('/home', [LoginController::class, 'home'])->middleware('auth');
