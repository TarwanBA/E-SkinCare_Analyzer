<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataproduk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class DataprodukController extends Controller
{
    public function index(Request $request) {
        $query = Dataproduk::query();
        
        // Jika ada input pencarian
        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
        }
    
        // Gunakan cache untuk menyimpan hasil pagination selama 10 menit
        $produk = Cache::remember('produk_list_' . $request->search, now()->addMinutes(10), function () use ($query) {
            return $query->paginate(10);
        });

        return view('backend.data-produk', compact('produk'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        // Gunakan cache untuk menyimpan data detail produk selama 10 menit
        $produk = Cache::remember('produk_detail_' . $id, now()->addMinutes(10), function () use ($id) {
            return Dataproduk::findOrFail($id);
        });

        return view('backend.data-produk.show', compact('produk'));
    }

    // Menampilkan form tambah produk
    public function create()
    {
        return view('backend.data-produk.create');
    }

    // Menyimpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'kode_produk' => 'required|string',
            'nama_produk' => 'required|string',
        ]);

        $produk = Dataproduk::create([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        // Hapus cache daftar produk agar data baru muncul di halaman index
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil ditambahkan.');
    }

    // Menampilkan form edit produk
    public function edit($id)
    {
        $produk = Dataproduk::findOrFail($id);
        return view('backend.data-produk.edit', compact('produk'));
    }

    // Mengupdate produk yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_produk' => 'required|string',
            'nama_produk' => 'required|string',
        ]);

        $produk = Dataproduk::findOrFail($id);
        $produk->update([
            'kode_produk' => $request->kode_produk,
            'nama_produk' => $request->nama_produk,
        ]);

        // Hapus cache detail produk dan daftar produk agar data terbaru muncul
        Cache::forget('produk_detail_' . $id);
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Dataproduk::findOrFail($id);
        $produk->delete();

        // Hapus cache daftar produk agar data terbaru muncul
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil dihapus.');
    }

    // Fungsi cetak PDF
    public function cetak()
    {
        // Gunakan cache untuk menyimpan data cetak selama 10 menit
        $dataproduk = Cache::remember('produk_cetak', now()->addMinutes(10), function () {
            return Dataproduk::all();
        });

        // Render ke dalam view cetak-data-produk.blade.php
        $pdf = Pdf::loadView('backend.cetak-data-produk', compact('dataproduk'));

        return $pdf->stream('laporan-data-produk.pdf');
    }
}
