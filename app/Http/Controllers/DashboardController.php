<?php

namespace App\Http\Controllers;

use App\Models\Dataproduk;
use App\Models\DataTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        // Cache jumlah produk selama 10 menit
        $data_produk = Cache::remember('data_produk_count', now()->addMinutes(10), function () {
            return Dataproduk::count();
        });

        // Cache jumlah transaksi selama 10 menit
        $data_transaksi = Cache::remember('data_transaksi_count', now()->addMinutes(10), function () {
            return DataTransaksi::count();
        });

        return view('backend.dashboard', compact('data_produk', 'data_transaksi'));
    }
}
