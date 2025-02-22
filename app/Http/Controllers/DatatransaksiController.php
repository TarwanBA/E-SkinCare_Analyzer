<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

class DatatransaksiController extends Controller
{
    public function index()
    {
        $datapagi = DataTransaksi::paginate(10);
        $datatransaksi = DataTransaksi::all();
        
        // Mengirim data untuk ditampilkan ke view
        return view('backend.data-transaksi', compact('datapagi', 'datatransaksi'));
    }
    

    
    

    // Menampilkan detail transaksi
    public function show($id)
    {
        $transaksi = DataTransaksi::findOrFail($id);
        return view('backend.data-transaksi.show', compact('transaksi'));
    }

    // Menampilkan form tambah transaksi
    public function create()
    {
        return view('backend.data-transaksi.create');
    }

    // Menyimpan transaksi baru
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_produk' => 'required|string',
        ]);

        DataTransaksi::create([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    // Menampilkan form edit transaksi
    public function edit($id)
    {
        $transaksi = DataTransaksi::findOrFail($id);
        return view('backend.data-transaksi.edit', compact('transaksi'));
    }

    // Mengupdate transaksi yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_transaksi' => 'required|date',
            'nama_produk' => 'required|string',
        ]);

        $transaksi = DataTransaksi::findOrFail($id);
        $transaksi->update([
            'tanggal_transaksi' => $request->tanggal_transaksi,
            'nama_produk' => $request->nama_produk,
        ]);

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = DataTransaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }


    public function upload(Request $request)
{
    // Validasi file yang diunggah
    $validated = $request->validate([
        'file' => 'required|file|mimes:xlsx,xls',
    ]);

    // Ambil file dan load spreadsheet
    $file = $request->file('file');
    $spreadsheet = IOFactory::load($file->getPathname());
    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();

    // Iterasi melalui setiap baris (kecuali header)
    foreach ($rows as $key => $row) {
        if ($key === 0) continue; // Lewatkan baris header

        // Mengonversi tanggal dari format Excel atau string ke tanggal
        $excelTimestamp = $row[0];

        // Cek apakah nilai adalah angka atau string dengan format tanggal
        if (is_numeric($excelTimestamp)) {
            // Jika angka, langsung konversi
            $tanggal_transaksi = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelTimestamp);
            $formatted_tanggal = Carbon::parse($tanggal_transaksi)->format('Y-m-d');
        } elseif (strtotime($excelTimestamp)) {
            // Jika tanggal dalam format string, gunakan strtotime dan Carbon
            $tanggal_transaksi = Carbon::parse($excelTimestamp);
            $formatted_tanggal = $tanggal_transaksi->format('Y-m-d');
        } else {
            // Jika format tidak valid, lanjutkan ke baris berikutnya
            continue;
        }

        // Pastikan nama_produk adalah string yang valid
        $nama_produk = trim($row[1] ?? ''); // Trim untuk menghindari spasi yang tidak diinginkan

        // Menyimpan data transaksi ke database
        DataTransaksi::create([
            'tanggal_transaksi' => $formatted_tanggal,
            'nama_produk' => $nama_produk,
        ]);
    }

    // Redirect setelah upload berhasil
    return redirect()->route('data-transaksi.index')->with('status', 'Data transaksi berhasil diupload!');
}

public function cetak()
    {
        $datatransaksi = DataTransaksi::all(); // Ambil data dari database

        // Render ke dalam view report-pdf.blade.php
        $pdf = Pdf::loadView('backend.cetak-data-transaksi', compact('datatransaksi'));

         // return $pdf->download('laporan.pdf'); // Unduh file PDF
         return $pdf->stream('laporan-data-transaksi.pdf');
    }

}
