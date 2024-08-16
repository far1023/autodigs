<?php

use App\Http\Controllers\Access\PermissionController;
use App\Http\Controllers\Access\PermitGrantingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Access\RoleController;
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

Route::post('/login', [LoginController::class, 'attempt'])->name('login.attempt');
Route::post('/logout', [LogoutController::class, 'run'])->name('user.logout');

Route::middleware('auth')->group(function () {
    Route::get('/beranda', [BerandaController::class, 'index'])->name('beranda');

    Route::prefix('controls/role')->group(function () {
        Route::controller(RoleController::class)->group(function () {
            Route::get('/', 'index')->middleware('can:show-any-role')->name('role.index');
            Route::get('/tambah', 'add')->middleware('can:add-role')->name('role.add');
            Route::get('/edit/{role}', 'edit')->middleware('can:edit-role')->name('role.edit');

            Route::post('/', 'store')->middleware('can:add-role')->name('role.store');
            Route::patch('/{role}', 'update')->middleware('can:edit-role')->name('role.update');
            Route::delete('/{role}', 'delete')->middleware('can:delete-role')->name('role.delete');
        });

        Route::controller(PermitGrantingController::class)->middleware('can:grant-permit')->group(function () {
            Route::get('/{id}/grant-permit', 'edit')->name('role.show-permit');
            Route::patch('/{role}/grant-permit', 'update')->name('role.grant-permit');
        });
    });

    Route::prefix('controls/permission')->controller(PermissionController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:show-any-permission')->name('permission.index');
        Route::get('/tambah', 'add')->middleware('can:add-permission')->name('permission.add');
        Route::get('/edit/{permission}', 'edit')->middleware('can:edit-permission')->name('permission.edit');

        Route::post('/', 'store')->middleware('can:add-permission')->name('permission.store');
        Route::patch('/{permission}', 'update')->middleware('can:edit-permission')->name('permission.update');
        Route::delete('/{permission}', 'delete')->middleware('can:delete-permission')->name('permission.delete');
    });

    Route::prefix('pengguna')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->middleware('can:show-any-user')->name('user.index');
        Route::get('/tambah', 'add')->middleware('can:add-user')->name('user.add');
        Route::get('/edit/{user}', 'edit')->middleware('can:edit-user')->name('user.edit');

        Route::post('/', 'store')->middleware('can:add-user')->name('user.store');
        Route::patch('/{user}', 'update')->middleware('can:edit-user')->name('user.update');
        Route::delete('/{user}', 'delete')->middleware('can:delete-user')->name('user.delete');

        Route::get('/{id}/assign-role', 'edit')->name('role.show-role');
        Route::patch('/{user}/assign-role', 'update')->name('role.assign-role');
    });
});
