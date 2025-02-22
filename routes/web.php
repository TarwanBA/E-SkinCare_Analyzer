<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataprodukController;
use App\Http\Controllers\DatatransaksiController;
use App\Http\Controllers\ProsesController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CekProsesSelesai;



Route::middleware(['auth'])->group(function () {
  
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Rute untuk data produk
    Route::get('/data-produk', [DataprodukController::class, 'index'])->name('data-produk.index');
    Route::get('/data-produk/{id}', [DataprodukController::class, 'show'])->name('data-produk.show');
    Route::get('/data-produk/create', [DataprodukController::class, 'create'])->name('data-produk.create');
    Route::post('/data-produk', [DataprodukController::class, 'store'])->name('data-produk.store');
    Route::get('/data-produk/{id}/edit', [DataprodukController::class, 'edit'])->name('data-produk.edit');
    Route::put('/data-produk/{id}', [DataprodukController::class, 'update'])->name('data-produk.update');
    Route::delete('/data-produk/{id}', [DataprodukController::class, 'destroy'])->name('data-produk.destroy');
    Route::get('/cetak-data-produk', [DataprodukController::class, 'cetak'])->name('data-produk.cetak');


    // Rute untuk data transaksi
    Route::get('/data-transaksi', [DataTransaksiController::class, 'index'])->name('data-transaksi.index');
    Route::get('/data-transaksi/{id}', [DataTransaksiController::class, 'show'])->name('data-transaksi.show');
    Route::get('/data-transaksi/create', [DataTransaksiController::class, 'create'])->name('data-transaksi.create');
    Route::post('/data-transaksi', [DataTransaksiController::class, 'store'])->name('data-transaksi.store');
    Route::get('/data-transaksi/{id}/edit', [DataTransaksiController::class, 'edit'])->name('data-transaksi.edit');
    Route::put('/data-transaksi/{id}', [DataTransaksiController::class, 'update'])->name('data-transaksi.update');
    Route::delete('/data-transaksi/{id}', [DataTransaksiController::class, 'destroy'])->name('data-transaksi.destroy');

    Route::post('/data-transaksi/upload', [DataTransaksiController::class, 'upload'])->name('data-transaksi.upload');
    Route::get('/cetak-data-transaksi', [DataTransaksiController::class, 'cetak'])->name('data-transaksi.cetak');
    
    Route::get('/proses-data', [ProsesController::class, 'index'])->name('proses-data.index');
    // Route::get('/hasil-prosfdes', [ProsesController::class, 'hasil'])->name('hasil-proses.hasil');

    Route::get('/analyzer', [ProsesController::class, 'analyzer'])->name('proses.analyzer');
    Route::get('/hasil-proses', [ProsesController::class, 'hasil'])->name('hasil.proses')->middleware(CekProsesSelesai::class);
    Route::get('/cetak', [ProsesController::class, 'cetak'])->name('cetak.hasil');

});




Route::middleware(['guest'])->get('login', [LoginController::class, 'showLoginForm']);



Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout'])->name('logout');


Route::get('/lupa-password', [UserController::class, 'index'])->name('password.index');

Route::post('/lupa-password', [UserController::class, 'updatePassword'])->name('password.updatePassword');