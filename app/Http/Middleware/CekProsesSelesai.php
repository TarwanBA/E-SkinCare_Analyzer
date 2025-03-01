<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekProsesSelesai
{
    public function handle(Request $request, Closure $next)
    {
        // Memeriksa apakah status proses sudah selesai di session
        if (session('status_proses') !== 'selesai') {
            // Jika belum selesai, redirect ke halaman yang diinginkan
            return redirect()->route('proses-data.index')->with('error', 'Proses belum dijalankan. Silakan jalankan. Klik Tombol Analyzer Data');
        }

        // Jika sudah selesai, lanjutkan permintaan
        return $next($request);
    }
}

