<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\LaporanController;

// Login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/', function () {
    return redirect('/login');
});

use App\Http\Controllers\VoucherController;

// Route Admin
Route::prefix('admin')->middleware('role:Admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.dashboard', [
            'totalCustomer' => \App\Models\Customer::count(),
            'totalUser' => \App\Models\User::count(),
            'totalService' => \App\Models\TypeOfService::count(),
            'totalOrder' => \App\Models\TransOrder::whereDate('order_date', today())->count(),
        ]);
    });

    Route::get('/user', [UserController::class, 'index']);
    Route::get('/user/create', [UserController::class, 'create']);
    Route::post('/user', [UserController::class, 'store']);
    Route::get('/user/{id}/edit', [UserController::class, 'edit']);
    Route::put('/user/{id}', [UserController::class, 'update']);
    Route::delete('/user/{id}', [UserController::class, 'destroy']);

    Route::get('/service', [ServiceController::class, 'index']);
    Route::get('/service/create', [ServiceController::class, 'create']);
    Route::post('/service', [ServiceController::class, 'store']);
    Route::get('/service/{id}/edit', [ServiceController::class, 'edit']);
    Route::put('/service/{id}', [ServiceController::class, 'update']);
    Route::delete('/service/{id}', [ServiceController::class, 'destroy']);

    Route::get('/voucher', [VoucherController::class, 'index']);
    Route::get('/voucher/create', [VoucherController::class, 'create']);
    Route::post('/voucher', [VoucherController::class, 'store']);
    Route::get('/voucher/{id}/edit', [VoucherController::class, 'edit']);
    Route::put('/voucher/{id}', [VoucherController::class, 'update']);
    Route::delete('/voucher/{id}', [VoucherController::class, 'destroy']);
});

// Route yang BISA diakses Admin & Operator secara bersamaan
Route::middleware('role:Admin,Operator')->group(function () {
    Route::get('/admin/customer', [CustomerController::class, 'index']);
    Route::get('/admin/customer/create', [CustomerController::class, 'create']);
    Route::post('/admin/customer', [CustomerController::class, 'store']);
    Route::get('/admin/customer/{id}/edit', [CustomerController::class, 'edit']);
    Route::put('/admin/customer/{id}', [CustomerController::class, 'update']);
    Route::delete('/admin/customer/{id}', [CustomerController::class, 'destroy']);

    Route::post('/operator/voucher/check', [VoucherController::class, 'check']);
});


// Route Operator
Route::prefix('operator')->middleware('role:Operator,Admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('operator.dashboard');
    });

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    Route::post('/transaksi', [TransaksiController::class, 'store']);
    Route::get('/transaksi/{id}', [TransaksiController::class, 'show']);

    Route::get('/pickup', [PickupController::class, 'index']);
    Route::get('/pickup/{id}', [PickupController::class, 'show']);
    Route::post('/pickup/{id}', [PickupController::class, 'proses']);
});

// Route Pimpinan
Route::prefix('pimpinan')->middleware('role:Pimpinan')->group(function () {
    Route::get('/laporan', [LaporanController::class, 'index']);
});