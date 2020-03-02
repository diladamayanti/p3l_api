<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDTProduksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('DTproduks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('noTransaksi');
            $table->integer('idProduk');
            $table->integer('jumlah');
            $table->float('subTotal');
            $table->dateTime('tglTransaksi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('DTproduks');
    }
}
