<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataTransaksi extends Model
{
    use HasFactory;

    protected $table = 'data_transaksi';

    protected $fillable = [
        'tanggal_transaksi',
        'nama_produk',
    ];

    protected $dates = ['tanggal_transaksi'];
}
