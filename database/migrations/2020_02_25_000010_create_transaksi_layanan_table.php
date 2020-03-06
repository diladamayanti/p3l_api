<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksiLayanan', function (Blueprint $table) {
            $table->string('noTransaksi');
            $table->date('tglTransaksi');
            $table->double('totalBiaya');
            $table->string('statusLayanan');
            $table->string('statusPembayaran');
            $table->integer('idCustomer')->unsigned();
            $table->string('idCustomerService');
            $table->string('idKasir');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();

            $table->primary('noTransaksi');
            $table->foreign('idCustomer')->references('idCustomer')->on('customer');
            $table->foreign('idCustomerService')->references('NIP')->on('pegawai');
            $table->foreign('idKasir')->references('NIP')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksiLayanan');
    }
}
