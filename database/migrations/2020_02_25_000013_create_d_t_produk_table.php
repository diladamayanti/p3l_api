<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtproduk', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noTransaksi');
            $table->foreign('noTransaksi')->references('noTransaksi')->on('transaksiProduk');
            $table->string('idProduk');
            $table->foreign('idProduk')->references('idProduk')->on('produk');
            $table->integer('jumlah');
            $table->double('subTotal');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dtproduk');
    }
}
