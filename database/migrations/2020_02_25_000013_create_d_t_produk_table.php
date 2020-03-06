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
            $table->string('noTransaksi');
            $table->string('idProduk');
            $table->integer('jumlah');
            $table->double('subTotal');

            $table->primary('noTransaksi','idProduk');
            $table->foreign('noTransaksi')->references('noTransaksi')->on('transaksiProduk');
            $table->foreign('idProduk')->references('idProduk')->on('produk');
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
