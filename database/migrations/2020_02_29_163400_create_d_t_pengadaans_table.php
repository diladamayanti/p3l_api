<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTPengadaansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DTpengadaans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noPO');
            $table->integer('idProduk');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->float('subTotal');
            $table->dateTime('tglPengadaan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DTpengadaans');
    }
}
