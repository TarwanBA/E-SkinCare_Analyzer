<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataproduk;
use Barryvdh\DomPDF\Facade\Pdf;

class DataprodukController extends Controller
{
    public function index(Request $request) {
        $query = Dataproduk::query();
        
        // Jika ada input pencarian
        if ($request->has('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_produk', 'like', '%' . $request->search . '%');
        }
    
        // Pagination
        $produk = $query->paginate(10);
    
        return view('backend.data-produk', compact('produk'));
    }
    


     // Menampilkan detail produk
     public function show($id)
     {
         $produk = Dataproduk::findOrFail($id);
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
 
         Dataproduk::create([
             'kode_produk' => $request->kode_produk,
             'nama_produk' => $request->nama_produk,
         ]);
 
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
 
         return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil diperbarui.');
     }
 
     // Menghapus produk
     public function destroy($id)
     {
         $produk = Dataproduk::findOrFail($id);
         $produk->delete();
 
         return redirect()->route('data-produk.index')->with('success', 'Data produk berhasil dihapus.');
     }

     public function cetak()
    {
        $dataproduk = Dataproduk::all(); // Ambil data dari database

        // Render ke dalam view report-pdf.blade.php
        $pdf = Pdf::loadView('backend.cetak-data-produk', compact('dataproduk'));

         // return $pdf->download('laporan.pdf'); // Unduh file PDF
         return $pdf->stream('laporan-data-produk.pdf');
    }
}
