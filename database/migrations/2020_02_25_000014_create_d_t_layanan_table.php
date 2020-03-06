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
            $table->string('noTransaksi');
            $table->string('idLayanan');
            $table->integer('jumlah');
            $table->double('subTotal');

            $table->primary('noTransaksi','idLayanan');
            $table->foreign('idLayanan')->references('idLayanan')->on('layanan');
            $table->foreign('noTransaksi')->references('noTransaksi')->on('transaksiLayanan');
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
