<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTPengadaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dtpengadaan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noPO');
            $table->foreign('noPO')->references('noPO')->on('pengadaan');
            $table->string('idProduk');
            $table->foreign('idProduk')->references('idProduk')->on('produk');
            $table->integer('jumlah');
            $table->string('satuan');
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
        Schema::dropIfExists('dtpengadaan');
    }
}
