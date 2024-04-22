<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuperAdmin\HomeController;
use App\Http\Controllers\SuperAdmin\User\UserController;
use App\Http\Controllers\SuperAdmin\Profile\ProfileController;
use App\Http\Controllers\SuperAdmin\RolePermission\RoleController;
use App\Http\Controllers\SuperAdmin\Membership\MembershipController;
use App\Http\Controllers\SuperAdmin\Transaction\TransactionController;
use App\Http\Controllers\SuperAdmin\RolePermission\PermissionController;



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
    return view('dashboard');
})->name('dashboard');


Route::group([
    'prefix' => 'dashboard',
    'as' => 'dashboard.',
    'middleware' => 'auth'
], function(){
    Route::get('/index', [HomeController::class, 'index'])->name('index');
    // Role
    Route::group([
        'prefix' => 'role',
        'as' => 'role.'
    ], function(){
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/data', [RoleController::class, 'data'])->name('data');
        Route::get('/{id}', [RoleController::class, 'show'])->name('show');
        Route::post('/store', [RoleController::class, 'store'])->name('store');
        Route::delete('/{id}', [RoleController::class, 'destroy'])->name('destroy');
    });
    // Permission
    Route::group([
        'prefix' => 'permission',
        'as' => 'permission.'
    ], function(){
        Route::get('/{id}', [PermissionController::class, 'index'])->name('index');
        Route::post('/addPermission', [PermissionController::class, 'addPermission'])->name('addPermission');
        Route::post('/{id}/store', [PermissionController::class, 'store'])->name('store');
    });
    // User
    Route::group([
        'prefix' => 'user',
        'as' => 'user.'
    ], function(){
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/data', [UserController::class, 'data'])->name('data');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });
    // Profile
    Route::group([
        'prefix' => 'profile',
        'as' => 'profile.'
    ], function(){
        Route::get('/', [ProfileController::class, 'index'])->name('index');
    });
    // Paket Membership
    Route::group([
        'prefix' => 'membership',
        'as' => 'membership.'
    ], function(){
        Route::get('/', [MembershipController::class, 'index'])->name('index');
        Route::get('/data', [MembershipController::class, 'data'])->name('data');
        Route::get('/{id}', [MembershipController::class, 'show'])->name('show');
        Route::post('/store', [MembershipController::class, 'store'])->name('store');
        Route::delete('/{id}', [MembershipController::class, 'destroy'])->name('destroy');
    });
    // Transaksi
    Route::group([
        'prefix' => 'transaction',
        'as' => 'transaction.'
    ], function(){
        Route::get('/detail-transaction', [TransactionController::class, 'index'])->name('index');
        Route::get('/data', [TransactionController::class, 'data'])->name('data');
        Route::get('/{id}', [TransactionController::class, 'show'])->name('show');
        Route::get('/filter', [TransactionController::class, 'filter'])->name('filter');
        Route::post('/store', [TransactionController::class, 'store'])->name('store');
        Route::delete('/{id}', [TransactionController::class, 'destroy'])->name('destroy');
        Route::post('/non-active-membership/{id}', [TransactionController::class, 'nonActiveMembership'])->name('nonActiveMembership');
    });
});

require __DIR__.'/auth.php';