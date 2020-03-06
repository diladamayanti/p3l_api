<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLayananTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('layanan', function (Blueprint $table) {
            $table->string('idLayanan');
            $table->string('namaLayanan');
            $table->double('harga');
            $table->integer('idJenis')->unsigned();
            $table->integer('idUkuran')->unsigned();
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            $table->dateTime('deleted_at')->nullable();
            $table->string('idPegawaiLog');
            
            $table->primary('idLayanan');
            $table->foreign('idJenis')->references('idJenis')->on('jenisHewan');
            $table->foreign('idUkuran')->references('idUkuran')->on('ukuranHewan');
            $table->foreign('idPegawaiLog')->references('NIP')->on('pegawai');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('layanan');
    }
}
