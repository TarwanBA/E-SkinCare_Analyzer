<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dataproduk extends Model
{
    protected $table = 'data_produk';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
    ];

}
