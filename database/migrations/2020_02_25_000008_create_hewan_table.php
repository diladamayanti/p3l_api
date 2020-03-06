<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHewanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hewan', function (Blueprint $table) {
            $table->increments('idHewan');
            $table->string('namaHewan');
            $table->date('tglLahir');
            $table->integer('idJenis')->unsigned();
            $table->integer('idCustomer')->unsigned();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('idPegawaiLog');

            $table->foreign('idCustomer')->references('idCustomer')->on('customer');
            $table->foreign('idJenis')->references('idJenis')->on('jenisHewan');
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
        Schema::dropIfExists('hewan');
    }
}
