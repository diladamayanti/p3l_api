<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransaksiLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaksi_layanans', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noTransaksi');
            $table->float('totalBiaya');
            $table->string('statusLayanan');
            $table->string('statusPembayaran');
            $table->integer('idCustomer');
            $table->integer('idCustomerService');
            $table->integer('idKasir');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_layanans');
    }
}
