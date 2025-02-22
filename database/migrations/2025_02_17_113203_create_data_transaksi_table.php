<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataTransaksiTable extends Migration
{
    public function up()
    {
        Schema::create('data_transaksi', function (Blueprint $table) {
            $table->id(); 
            $table->date('tanggal_transaksi'); 
            $table->string('nama_produk'); 
            $table->timestamps(); 
        });
    }

    public function down()
    {
        Schema::dropIfExists('data_transaksi');
    }
}
