<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;

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
    if (Auth::check()) {
        return redirect()->route('beranda');
    }

    return view('login');
});

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('beranda');
    }

    return view('login');
});

Route::post('/login', [LoginController::class, 'run'])->name('run.login');
Route::post('/logout', [LogoutController::class, 'run'])->name('user.logout');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    Route::get('/pengguna', [UserController::class, 'index'])->middleware('can:show user')->name('user.index');
    Route::get('/pengguna/tambah', [UserController::class, 'add'])->middleware('can:add user')->name('user.add');
    Route::get('/pengguna/edit/{user}', [UserController::class, 'edit'])->middleware('can:edit user')->name('user.edit');

    Route::post('/pengguna', [UserController::class, 'store'])->middleware('can:add user')->name('user.store');
    Route::patch('/pengguna/{user}', [UserController::class, 'update'])->middleware('can:edit user')->name('user.update');
    Route::delete('/pengguna/{user}', [UserController::class, 'delete'])->middleware('can:delete user')->name('user.delete');
});
