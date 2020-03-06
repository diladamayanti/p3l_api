<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiPengadaanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksiPengadaan', function (Blueprint $table) {
            $table->string('noPO');
            $table->date('tglPengadaan');
            $table->integer('idSupplier')->unsigned();
            $table->string('status');
            $table->double('totalHarga');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');

            $table->primary('noPO');
            $table->foreign('idSupplier')->references('idSupplier')->on('supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksiPengadaan');
    }
}
