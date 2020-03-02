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
            $table->foreign('idJenis')->references('idJenis')->on('jenisHewan');
            $table->integer('idCustomer')->unsigned();
            $table->foreign('idCustomer')->references('idCustomer')->on('customer');
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->string('idPegawaiLog');
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
