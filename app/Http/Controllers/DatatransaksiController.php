<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataTransaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Cache;

class DatatransaksiController extends Controller
{
    public function index()
    {
        $datapagi = Cache::remember('transaksi_pagination', now()->addMinutes(1), function () {
            return DataTransaksi::all();
        });

        $datatransaksi = Cache::remember('transaksi_all', now()->addMinutes(1), function () {
            return DataTransaksi::all();
        });

        return view('backend.data-transaksi', compact('datapagi', 'datatransaksi'));
    }

    // Menampilkan detail transaksi
    public function show($id)
    {
        
        $transaksi = Cache::remember('transaksi_detail_' . $id, now()->addMinutes(10), function () use ($id) {
            return DataTransaksi::findOrFail($id);
        });

        return view('backend.data-transaksi.show', compact('transaksi'));
    }

    // Menampilkan form
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

        // Hapus cache
        Cache::forget('transaksi_pagination');
        Cache::forget('transaksi_all');

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil ditambahkan.');
    }

    // Menampilkan form
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

        // Hapus cache
        Cache::forget('transaksi_detail_' . $id);
        Cache::forget('transaksi_pagination');
        Cache::forget('transaksi_all');

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil diperbarui.');
    }

    // Menghapus transaksi
    public function destroy($id)
    {
        $transaksi = DataTransaksi::findOrFail($id);
        $transaksi->delete();

        // Hapus cache
        Cache::forget('transaksi_detail_' . $id);
        Cache::forget('transaksi_pagination');
        Cache::forget('transaksi_all');

        return redirect()->route('data-transaksi.index')->with('success', 'Data transaksi berhasil dihapus.');
    }

    // Upload File
    public function upload(Request $request)
    {
        // Validasi file
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        foreach ($rows as $key => $row) {
            if ($key === 0) continue; 

            $excelTimestamp = $row[0];

            if (is_numeric($excelTimestamp)) {
                $tanggal_transaksi = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($excelTimestamp);
                $formatted_tanggal = Carbon::parse($tanggal_transaksi)->format('Y-m-d');
            } elseif (strtotime($excelTimestamp)) {
                $tanggal_transaksi = Carbon::parse($excelTimestamp);
                $formatted_tanggal = $tanggal_transaksi->format('Y-m-d');
            } else {
                continue;
            }

            $nama_produk = trim($row[1] ?? '');

            DataTransaksi::create([
                'tanggal_transaksi' => $formatted_tanggal,
                'nama_produk' => $nama_produk,
            ]);
        }

        // Hapus cache
        Cache::forget('transaksi_pagination');
        Cache::forget('transaksi_all');

        return redirect()->route('data-transaksi.index')->with('status', 'Data transaksi berhasil diupload!');
    }

    public function cetak()
    {
        // Gunakan cache untuk menyimpan data cetak selama 10 menit
        $datatransaksi = Cache::remember('transaksi_cetak', now()->addMinutes(10), function () {
            return DataTransaksi::all();
        });

        $pdf = Pdf::loadView('backend.cetak-data-transaksi', compact('datatransaksi'));

        return $pdf->stream('laporan-data-transaksi.pdf');
    }
}
