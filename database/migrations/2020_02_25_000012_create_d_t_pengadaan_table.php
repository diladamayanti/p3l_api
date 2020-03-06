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
            $table->string('noPO');
            $table->string('idProduk');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->double('subTotal');
        
            $table->primary('noPO','idProduk');
            $table->foreign('noPO')->references('noPO')->on('pengadaan');
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
        Schema::dropIfExists('dtpengadaan');
    }
}
