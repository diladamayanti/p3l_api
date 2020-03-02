<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayanansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanans', function (Blueprint $table) {
            $table->string('idLayanan');
            $table->primary('idLayanan');
            $table->string('namaLayanan');
            $table->float('harga');
            $table->integer('idJenis')->unsigned();
            $table->foreign('idJenis')->references('id')->on('jenis_hewans');
            $table->integer('idUkuran')->unsigned();
            $table->foreign('idUkuran')->references('id')->on('ukuran_hewans');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanans');
    }
}
