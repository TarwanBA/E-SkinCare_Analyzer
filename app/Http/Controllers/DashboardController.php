<?php

namespace App\Http\Controllers;

use App\Models\Dataproduk;
use App\Models\DataTransaksi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $data_produk = Dataproduk::count();
        $data_transaksi = DataTransaksi::count();

        return view('backend.dashboard', compact('data_produk', 'data_transaksi'));
    }
}
