<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-data',[UserController::class, 'getData'])->name('getData');
Route::post('/register',[UserController::class, 'register'])->name('register');
Route::get('/delete',[UserController::class, 'delete'])->name('delete');
Route::get('/edit',[UserController::class, 'edit'])->name('edit');