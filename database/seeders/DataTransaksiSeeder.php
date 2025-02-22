<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DataTransaksiSeeder extends Seeder
{
    public function run()
    {
        DB::table('data_transaksi')->insert([
            [
                'tanggal_transaksi' => Carbon::createFromFormat('d/m/Y', '10/12/2023')->toDateString(),
                'nama_produk' => 'Moist Skintific, Cream Emina, Sunscreen Facetology',
            ],
            [
                'tanggal_transaksi' => Carbon::createFromFormat('d/m/Y', '18/12/2023')->toDateString(),
                'nama_produk' => 'Moist Skintific, Cream Emina, Serum Garnier, Facial Wash Wardah',
            ],
            [
                'tanggal_transaksi' => Carbon::createFromFormat('d/m/Y', '12/01/2024')->toDateString(),
                'nama_produk' => 'Moist Skintific, Sunscreen Facetology, Serum Garnier',
            ],
            [
                'tanggal_transaksi' => Carbon::createFromFormat('d/m/Y', '22/01/2024')->toDateString(),
                'nama_produk' => 'Moist Skintific, Cream Emina, Sunscreen Facetology, Face Wash Wardah',
            ],
            [
                'tanggal_transaksi' => Carbon::createFromFormat('d/m/Y', '28/01/2024')->toDateString(),
                'nama_produk' => 'Moist Skintific, Cream Emina, Serum Garnier',
            ],
        ]);
    }
}
