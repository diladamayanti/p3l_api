<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DTlayanan', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noTransaksi');
            $table->foreign('noTransaksi')->references('noTransaksi')->on('transaksiLayanan');
            $table->string('idLayanan');
            $table->foreign('idLayanan')->references('idLayanan')->on('layanan');
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
        Schema::dropIfExists('DTlayanan');
    }
}
