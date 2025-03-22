<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataproduk;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;

class DataprodukController extends Controller
{
    public function index(Request $request) 
    {
        $produk = Dataproduk::all();

        return view('backend.data-produk', compact('produk'));
    }

    // Menampilkan detail produk
    public function show($id)
    {
        $produk = Cache::remember('produk_detail_' . $id, now()->addMinutes(10), function () use ($id) {
            return Dataproduk::findOrFail($id);
        });

        return view('backend.data-produk.show', compact('produk'));
    }

    // Menampilkan form
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

        // Hapus cache
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil ditambahkan.');
    }

    // Menampilkan form
    public function edit($id)
    {
        $produk = Dataproduk::findOrFail($id);
        return view('backend.data-produk.edit', compact('produk'));
    }

    // Mengupdate produk
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

        // Hapus cache
        Cache::forget('produk_detail_' . $id);
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil diperbarui.');
    }

    // Menghapus produk
    public function destroy($id)
    {
        $produk = Dataproduk::findOrFail($id);
        $produk->delete();

        // Hapus cache
        Cache::forget('produk_list_');

        return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil dihapus.');
    }

    // Fungsi cetak PDF
    public function cetak()
    {
        $dataproduk = Cache::remember('produk_cetak', now()->addMinutes(10), function () {
            return Dataproduk::all();
        });

        // Render ke dalam view
        $pdf = Pdf::loadView('backend.cetak-data-produk', compact('dataproduk'));

        return $pdf->stream('laporan-data-produk.pdf');
    }
}
