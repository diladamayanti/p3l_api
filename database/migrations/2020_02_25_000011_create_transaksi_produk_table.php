<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiProdukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksiProduk', function (Blueprint $table) {
            $table->string('noTransaksi');
            $table->primary('noTransaksi');
            $table->double('totalBiaya');
            $table->string('statusPembayaran');
            $table->integer('idCustomer')->unsigned();
            $table->foreign('idCustomer')->references('idCustomer')->on('customer');
            $table->string('idCustomerService');
            $table->foreign('idCustomerService')->references('NIP')->on('pegawai');
            $table->string('idKasir');
            $table->foreign('idKasir')->references('NIP')->on('pegawai');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksiProduk');
    }
}
